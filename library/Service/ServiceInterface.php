<?php

namespace ImgManLibrary\Service;

use ImgManLibrary\Core\Adapter\AdapterInterface;
use ImgManLibrary\Storage\StorageInterface;

use Zend\ServiceManager\AbstractPluginManager;

interface ServiceInterface
{
    function __construct(AbstractPluginManager $serviceManger, AdapterInterface $imageAdapter, StorageInterface $storage);
} 