<?php
namespace ImgManLibrary\Service;

use ImgManLibrary\BlobAwareInterface;
use ImgManLibrary\BlobInterface;
use ImgManLibrary\Core\CoreAwareTrait;
use ImgManLibrary\Core\CoreInterface;
use ImgManLibrary\Operation\PluginManagerAwareTrait;
use ImgManLibrary\Service\Exception\InvalidArgumentException;
use ImgManLibrary\Service\Exception\InvalidRenditionException;
use ImgManLibrary\Storage\Exception\AlreadyIdExistException;
use ImgManLibrary\Storage\Exception\NotIdExistException;
use ImgManLibrary\Storage\StorageAwareTrait;
use ImgManLibrary\Storage\StorageInterface;

use Zend\ServiceManager\AbstractPluginManager;

abstract class AbstractService implements  ServiceInterface
{
    const STUB = 'rend/';

    use CoreAwareTrait;
    use StorageAwareTrait;
    use PluginManagerAwareTrait;

    protected $renditions = array();

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
     * @throws \ImgManLibrary\Service\Exception\InvalidRenditionException
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
     * @param AbstractPluginManager $pluginManager
     * @param CoreInterface $imageAdapter
     * @param StorageInterface $storage
     */
    function __construct(StorageInterface $storage = null, AbstractPluginManager $pluginManager = null, CoreInterface $imageAdapter = null)
    {
        if ($pluginManager) {
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
     * @throws \ImgManLibrary\Service\Exception\InvalidArgumentException;
     */
    public function grab(BlobInterface $blob, $identifier)
    {
        $renditions = $this->getRenditions();
        if (!empty($renditions)) {
            // Create rendition config image
            foreach ($renditions as $rendition => $setting) {
                // Save rendition config
                $this->save($identifier, $blob, $rendition);
            }
        }
        // Save ORIGINAL
        $this->save($identifier, $blob);
        return $identifier;
    }

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @param string $rendition
     * @return bool
     * @throws Exception\InvalidArgumentException
     * @throws \ImgManLibrary\Storage\Exception\AlreadyIdExistException
     */
    public function save($identifier, BlobInterface $blob, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        // Check adapter and identifier
        if (!$this->checkIdentifier($identifier)) {
            throw new InvalidArgumentException();
        }

        $id = $this->buildIdentifier($identifier, $rendition);
        if ($this->getStorage()->hasImage($id)) {
            throw new AlreadyIdExistException();
        }
        // Run operation setting for the rendition
        $this->applyRendition($blob, $rendition);

        $result = $this->getStorage()->saveImage($id, $this->getAdapter()->getBlob());
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
        $id = $this->buildIdentifier($identifier, $rendition);
        return $this->getStorage()->deleteImage($id);
    }

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @param string $rendition
     * @return bool
     * @throws \ImgManLibrary\Storage\Exception\NotIdExistException
     */
    public function update($identifier, BlobInterface $blob, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        $id = $this->buildIdentifier($identifier, $rendition);
        if (!$this->getStorage()->hasImage($id)) {
            throw new NotIdExistException();
        }
        // Run operation setting for the rendition
        $this->applyRendition($blob, $rendition);

        $result =  $this->getStorage()->updateImage($id,  $this->getAdapter()->getBlob());
        $this->getAdapter()->clear();
        return $result;
    }

    /**
     * @param $identifier
     * @param string $rendition
     * @return ImgManLibrary\Storage\Image\AbstractImageContainer|null
     */
    public function get($identifier, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        $id = $this->buildIdentifier($identifier, $rendition);
        $image =  $this->getStorage()->getImage($id);
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
        try {
            if( preg_match($this->regExIdentifier, $identifier ) == 0) {
                return false;
            }
            return true;

        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * @param $identifier
     * @param $rendition
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
        if(array_key_exists($rendition, $this->renditions)) {

            $operations = $this->renditions[$rendition];
            // make operation
            foreach ($operations as $helper => $params) {

                $this->getPluginManager()->get($helper)->setAdapter($this->getAdapter());
                $this->getPluginManager()->get($helper)->execute($params);
            }
        }
    }
} 