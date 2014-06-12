<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 12.31
 */

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
    const STUB = '/rend/';


    use CoreAwareTrait;
    use StorageAwareTrait;
    use PluginManagerAwareTrait;

    protected $renditions = array();

    private $regExIdentifier = "([^/]+)/?$";

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
     * @return AbstractService
     */
    public function setRenditions(array $renditions)
    {
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
     * @return bool
     * @throws Exception\InvalidArgumentException
     * @throws Exception\InvalidRenditionException
     */
    public function grab(BlobInterface $blob, $identifier)
    {

        if (!($this->getAdapter() instanceof BlobAwareInterface) || !$this->checkIdentifier($identifier)) {
            throw new InvalidArgumentException();
        }

        $original = clone $this->getAdapter()->setBlob($blob);

        $renditions = $this->getRenditions();
        if (!empty($renditions)) {

            if (array_key_exists(CoreInterface::RENDITION_ORIGINAL, $renditions)) {
                throw new InvalidRenditionException("Invalid rendition " . CoreInterface::RENDITION_ORIGINAL);
            }

            foreach ($renditions as $nameRendition => $setting) {

                $adapterRendition = clone  $original;
                $this->getPluginManager()->setAdapter($adapterRendition);
                // execute operation
                foreach ($setting as $nameHelper => $params) {

                    $this->getPluginManager()->get($nameHelper)->execute($params);
                }
                $this->save($identifier, $adapterRendition->getBlob(), $nameRendition);
            }
        }

        $this->save($identifier, $adapterRendition->getBlob());
        return $identifier;
    }

    /**
     * @param BlobInterface $blob
     * @param $identifier
     * @param string $rendition
     * @return bool
     * @throws \ImgManLibrary\Storage\Exception\AlreadyIdExistException
     */
    public function save($identifier, BlobInterface $blob, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        $id = $this->buildIdentifier($identifier, $rendition);

        if ($this->getStorage()->hasImage($id)) {
            throw new AlreadyIdExistException();
        }
        return $this->getStorage()->saveImage($id, $blob);
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
        return $this->getStorage()->updateImage($id, $blob);
    }


    public function get($identifier, $rendition = CoreInterface::RENDITION_ORIGINAL)
    {
        $id = $this->buildIdentifier($identifier, $rendition);


        return $this->getStorage()->getImage($id);
    }

    /**
     * @param $identifier
     * @return bool
     */
    private function checkIdentifier($identifier)
    {
        if(
        //    preg_match($this->regExIdentifier, $identifier ) == 0
        false
        ) {
            return false;
        }
        return true;
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
} 