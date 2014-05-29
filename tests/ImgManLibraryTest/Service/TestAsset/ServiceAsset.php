<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 17.42
 */

namespace ImgManLibraryTest\Service\TestAsset;

use ImgManLibrary\Core\Adapter\AdapterInterface;
use ImgManLibrary\Operation\PluginManagerAwareTrait;
use ImgManLibrary\Storage\StorageInterface;
use ImgManLibrary\Core\Adapter\AdapterAwareTrait;
use ImgManLibrary\Service\ServiceInterface;
use ImgManLibrary\Storage\StorageAwareTrait;

use Zend\ServiceManager\AbstractPluginManager;

class ServiceAsset  implements ServiceInterface
{
    use AdapterAwareTrait;
    use StorageAwareTrait;
    use PluginManagerAwareTrait;

    public function __construct(AbstractPluginManager $serviceManger, AdapterInterface $imageAdapter, StorageInterface $storage)
    {
        $this->setPluginManager($serviceManger);
        $this->setAdapter($imageAdapter);
        $this->setStorage($storage);
    }
} 