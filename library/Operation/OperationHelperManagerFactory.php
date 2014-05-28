<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 27/05/14
 * Time: 11.15
 */

namespace ImgManLibrary\Operation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OperationHelperManagerFactory implements FactoryInterface
{
    const PLUGIN_MANAGER_CLASS = 'ImgManLibrary\Operation\OperationPluginManager';

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $pluginManagerClass = static::PLUGIN_MANAGER_CLASS;
        /* @var $plugins \ImgManLibrary\Operation\OperationPluginManager */
        $plugins = new $pluginManagerClass;
        $plugins->setServiceLocator($serviceLocator);

        return $plugins;
    }
} 