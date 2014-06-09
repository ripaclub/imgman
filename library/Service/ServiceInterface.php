<?php

namespace ImgManLibrary\Service;

use ImgManLibrary\BlobInterface;
use ImgManLibrary\Core\CoreAwareInterface;
use ImgManLibrary\Core\CoreInterface;
use ImgManLibrary\Operation\PluginManagerAwareInterface;
use ImgManLibrary\Storage\StorageAwareInterface;
use ImgManLibrary\Storage\StorageInterface;

use Zend\ServiceManager\AbstractPluginManager;

interface ServiceInterface extends StorageAwareInterface, CoreAwareInterface, PluginManagerAwareInterface
{
    /**
     * @param AbstractPluginManager $serviceManger
     * @param CoreInterface $imageAdapter
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage, AbstractPluginManager $serviceManger = null, CoreInterface $imageAdapter = null);

    /**
     * @return array
     */
    public function getRenditions();

    /**
     * @param array $renditions
     * @return ServiceInterface
     */
    public function setRenditions(array $renditions);

    /**
     * @param BlobInterface $blob
     * @param $identifier
     * @return string|null
     */
    public function grab(BlobInterface $blob, $identifier);
} 