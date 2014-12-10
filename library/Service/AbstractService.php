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
use ImgMan\Storage\Image\AbstractStorageContainer;
use ImgMan\Storage\StorageAwareTrait;
use ImgMan\Storage\StorageInterface;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Class AbstractService
 */
abstract class AbstractService implements  ServiceInterface
{
    use CoreAwareTrait;
    use StorageAwareTrait;
    use PluginManagerAwareTrait;

    const RENDITION_SEPARATOR = '#';
    const CHAR_UNRESERVED = 'a-zA-Z0-9_\-\.~';

    /**
     * @var array
     */
    protected $renditions = [];

    /**
     * @var string
     */
    protected $regExIdentifier;

    /**
     * @param string $regExIdentifier
     */
    public function setRegExIdentifier($regExIdentifier)
    {
        $this->regExIdentifier = $regExIdentifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegExIdentifier()
    {
        if (!$this->regExIdentifier) {
            // Set default regex
            $pchar = '(?:[' . self::CHAR_UNRESERVED . ':@&=\+\$,]+|%[A-Fa-f0-9]{2})*';
            $segment = $pchar . "(?:;{$pchar})*";
            $regex = "/^{$segment}(?:\/{$segment})*$/";
            $this->regExIdentifier = $regex;
        }

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
            throw new InvalidRenditionException(sprintf('Invalid rendition "%s"', CoreInterface::RENDITION_ORIGINAL));
        }

        $this->renditions = $renditions;
        return $this;
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
        $this->checkIdentifier($identifier);

        $idImage = $this->buildIdentifier($identifier, $rendition);
        if ($this->getStorage()->hasImage($idImage)) {
            throw new IdAlreadyExistsException(sprintf('"%s" identifier already exists ', $identifier));
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
            throw new IdNotExistsException(sprintf('Identifier not found "%s"', $identifier));
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
     * @return AbstractStorageContainer|null
     */
    public function get($identifier, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        $idImage = $this->buildIdentifier($identifier, $rendition);
        $image =  $this->getStorage()->getImage($idImage);
        return $image;
    }

    /**
     * @param $identifier
     */
    protected function checkIdentifier($identifier)
    {
        if (strpos($identifier, static::RENDITION_SEPARATOR) !== false) {
            throw new InvalidArgumentException(sprintf(
               'Identifier can not contain the rendition separator ("%s")',
                static::RENDITION_SEPARATOR
            ));
        }

        if (!preg_match($this->getRegExIdentifier(), $identifier)) {
            throw new InvalidArgumentException(sprintf('"%s" does not match the identifier\'s regex pattern', $identifier));
        }
    }

    /**
     * @param string $identifier
     * @param string $rendition
     * @return string
     */
    protected function buildIdentifier($identifier, $rendition)
    {
        return $identifier . static::RENDITION_SEPARATOR . $rendition;
    }

    /**
     * @param BlobInterface $blob
     * @param $rendition
     */
    protected function applyRendition(BlobInterface $blob, $rendition)
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

    public function getStorage()
    {
        if (!$this->storage) {
            throw new \RuntimeException('No storage setting');
        }
        return $this->storage;
    }
}
