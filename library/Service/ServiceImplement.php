<?php

namespace ImgManLibrary\Service;

use ImgManLibrary\Core\Adapter\AdapterAwareTrait;
use ImgManLibrary\Core\Adapter\AdapterInterface;
use ImgManLibrary\Operation\PluginManagerAwareTrait;
use ImgManLibrary\Storage\StorageAwareTrait;
use ImgManLibrary\Storage\StorageInterface;

use Zend\ServiceManager\AbstractPluginManager;

class ServiceImplement implements  ServiceInterface
{
    use AdapterAwareTrait;
    use StorageAwareTrait;
    use PluginManagerAwareTrait;

    function __construct(AbstractPluginManager $pluginManager, AdapterInterface $imageAdapter, StorageInterface $storage)
    {
        $this->setPluginManager($pluginManager);
        $this->setAdapter($imageAdapter);
        $this->setStorage($storage);
    }
}