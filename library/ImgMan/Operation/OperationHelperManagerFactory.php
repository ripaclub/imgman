<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class OperationHelperManagerFactory
 */
class OperationHelperManagerFactory implements FactoryInterface
{
    const PLUGIN_MANAGER_CLASS = 'ImgMan\Operation\OperationPluginManager';

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return OperationPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $pluginManagerClass = static::PLUGIN_MANAGER_CLASS;
        /* @var $plugins \ImgMan\Operation\OperationPluginManager */
        $plugins = new $pluginManagerClass;
        $plugins->setServiceLocator($serviceLocator);

        return $plugins;
    }
}
