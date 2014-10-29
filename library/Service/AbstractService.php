<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Service;

use ImgMan\BlobInterface;
use ImgMan\Core\CoreAwareTrait;
use ImgMan\Core\CoreInterface;
use ImgMan\Operation\PluginManagerAwareTrait;
use ImgMan\Service\Exception\IdAlreadyExistsException;
use ImgMan\Service\Exception\IdNotExistsException;
use ImgMan\Service\Exception\InvalidArgumentException;
use ImgMan\Service\Exception\InvalidRenditionException;
use ImgMan\Storage\Exception\AlreadyIdExistException;
use ImgMan\Storage\Exception\NotIdExistException;
use ImgMan\Storage\Image\AbstractImageContainer;
use ImgMan\Storage\StorageAwareTrait;
use ImgMan\Storage\StorageInterface;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Class AbstractService
 */
abstract class AbstractService implements  ServiceInterface
{
    const STUB = 'rend/';

    use CoreAwareTrait;
    use StorageAwareTrait;
    use PluginManagerAwareTrait;

    protected $renditions = [];

    private $regExIdentifier = '/\/(\w+.)+\/$/';

    /**
     * @param string $regExIdentifier
     */
    public function setRegExIdentifier($regExIdentifier)
    {
        $this->regExIdentifier = $regExIdentifier;
    }

    /**
     * @return string
     */
    public function getRegExIdentifier()
    {
        return $this->regExIdentifier;
    }

    /**
     * @return mixed
     */
    public function getRenditions()
    {
        return $this->renditions;
    }

    /**
     * @param array $renditions
     * @return $this|ServiceInterface
     * @throws InvalidRenditionException
     */
    public function setRenditions(array $renditions)
    {
        if (array_key_exists(CoreInterface::RENDITION_ORIGINAL, $renditions)) {
            throw new InvalidRenditionException("Invalid rendition " . CoreInterface::RENDITION_ORIGINAL);
        }

        $this->renditions = $renditions;
        return $this;
    }

    /**
     * @param StorageInterface $storage
     * @param AbstractPluginManager $pluginManager
     * @param CoreInterface $imageAdapter
     */
    public function __construct(
        StorageInterface $storage = null,
        AbstractPluginManager $pluginManager = null,
        CoreInterface $imageAdapter = null
    ) {
        if ($storage) {
            $this->setStorage($storage);
        }

        if ($pluginManager) {
            $this->setPluginManager($pluginManager);
        }

        if ($imageAdapter) {
            $this->setAdapter($imageAdapter);
        }
    }

    /**
     * @param BlobInterface $blob
     * @param $identifier
     * @return null|string
     * @throws \ImgMan\Service\Exception\InvalidArgumentException;
     */
    public function grab(BlobInterface $blob, $identifier)
    {
        $renditions = $this->getRenditions();
        if (!empty($renditions)) {
            // Create rendition config image
            foreach ($renditions as $rendition => $setting) {

                $idImage = $this->buildIdentifier($identifier, $rendition);
                if ($this->getStorage()->hasImage($idImage)) {
                    // Save rendition config
                    $this->update($identifier, $blob, $rendition);
                } else {
                    // Save rendition config
                    $this->save($identifier, $blob, $rendition);
                }
            }
        }
        $idImage = $this->buildIdentifier($identifier, CoreInterface::RENDITION_ORIGINAL);
        if ($this->getStorage()->hasImage($idImage)) {
            // Save rendition config
            $this->update($identifier, $blob);
        } else {
            // Save rendition config
            $this->save($identifier, $blob);
        }
        return $identifier;
    }

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @param string $rendition
     * @return bool
     * @throws InvalidArgumentException
     * @throws IdAlreadyExistsException
     */
    public function save($identifier, BlobInterface $blob, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        // Check adapter and identifier
        if (!$this->checkIdentifier($identifier)) {
            throw new InvalidArgumentException();
        }

        $idImage = $this->buildIdentifier($identifier, $rendition);
        if ($this->getStorage()->hasImage($idImage)) {
            throw new IdAlreadyExistsException();
        }
        // Run operation setting for the rendition
        $this->applyRendition($blob, $rendition);

        $result = $this->getStorage()->saveImage($idImage, $this->getAdapter()->getBlob());
        $this->getAdapter()->clear();
        return $result;
    }

    /**
     * @param $identifier
     * @param string $rendition
     * @return bool
     */
    public function delete($identifier, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        $idImage = $this->buildIdentifier($identifier, $rendition);
        return $this->getStorage()->deleteImage($idImage);
    }

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @param string $rendition
     * @return bool
     * @throws IdNotExistsException
     */
    public function update($identifier, BlobInterface $blob, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        $idImage = $this->buildIdentifier($identifier, $rendition);
        if (!$this->getStorage()->hasImage($idImage)) {
            throw new IdNotExistsException();
        }
        // Run operation setting for the rendition
        $this->applyRendition($blob, $rendition);

        $result =  $this->getStorage()->updateImage($idImage, $this->getAdapter()->getBlob());
        $this->getAdapter()->clear();
        return $result;
    }

    /**
     * @param $identifier
     * @param string $rendition
     * @return AbstractImageContainer|null
     */
    public function get($identifier, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        $idImage = $this->buildIdentifier($identifier, $rendition);
        $image =  $this->getStorage()->getImage($idImage);
        if ($image) {
            $image->setMimeType($this->getAdapter()->getMimeType());
        }
        return $image;
    }

    /**
     * @param $identifier
     * @return bool
     */
    private function checkIdentifier($identifier)
    {
        $result = preg_match($this->regExIdentifier, $identifier );
        if( $result == 0 || $result == false) {
            return false;
        }
        return true;
    }

    /**
     * @param string $identifier
     * @param string $rendition
     * @return string
     */
    private function buildIdentifier($identifier, $rendition)
    {
        return $identifier . self::STUB . $rendition;
    }

    /**
     * @param BlobInterface $blob
     * @param $rendition
     */
    private function applyRendition(BlobInterface $blob, $rendition)
    {
        $this->getAdapter()->setBlob($blob);
        if (array_key_exists($rendition, $this->renditions)) {
            $operations = $this->renditions[$rendition];
            foreach ($operations as $helper => $params) {
                $this->getPluginManager()->get($helper)->setAdapter($this->getAdapter());
                $this->getPluginManager()->get($helper)->execute($params);
            }
        }
    }
}
