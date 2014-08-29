<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ImgMan\Storage\StorageInterface;

class ServiceFactory implements AbstractFactoryInterface
{

    /**
     * Config Key
     * @var string
     */
    protected $configKey = 'imgManServices';

    /**
     * Default service class name
     *
     * @var string
     */
    protected $serviceName = 'ImgMan\Service\ServiceImplement';

    /**
     * Config
     * @var array
     */
    protected $config;

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $this->getConfig($serviceLocator);
        if (empty($config)) {
            return false;
        }

        return (
            isset($config[$requestedName])  &&
            !empty($config[$requestedName]) &&
            // Check Storage
            isset($config[$requestedName]['storage']) &&
            is_string($config[$requestedName]['storage']) &&
            $serviceLocator->has($config[$requestedName]['storage']) &&
            // Check adapter and PluginManager
            (
                (
                    isset($config[$requestedName]['adapter']) &&
                    is_string($config[$requestedName]['adapter']) &&
                    $serviceLocator->has($config[$requestedName]['adapter']) &&
                    isset($config[$requestedName]['pluginManager']) &&
                    is_string($config[$requestedName]['pluginManager']) &&
                    $serviceLocator->has($config[$requestedName]['pluginManager'])
                ) || (  // Check not adapter and PluginManager
                    !isset($config[$requestedName]['adapter']) &&
                    !isset($config[$requestedName]['pluginManager'])
                )
            )
        );
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return StorageInterface
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $this->getConfig($serviceLocator)[$requestedName];
        $service = new $this->serviceName();
        if (isset($config['type']) && is_string($config['type']) &&
            !empty($config['type']) && $serviceLocator->has($config['type'])
        ) {

            $service = $serviceLocator->get($config['type']);
        }
        // Storage
        $storage = $serviceLocator->get($config['storage']);
        $adapter = null;
        $pluginManager = null;
        // Adapter and pluginManager
        if (isset($config['pluginManager']) && isset($config['adapter'])) {

            $adapter = $serviceLocator->get($config['adapter']);
            $pluginManager = $serviceLocator->get($config['pluginManager']);
            $pluginManager->setAdapter($adapter);
        }

        /* @var ServiceInterface $service */
        $service->setStorage($storage);
        if ($adapter) {
            $service->setAdapter($adapter);
        }
        if ($pluginManager) {
            $service->setPluginManager($pluginManager);
        }

        if (isset($config['renditions'])) {
            $service->setRenditions($config['renditions']);
        }

        return $service;
    }

    /**
     * Get model configuration, if any
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return array
     */
    protected function getConfig(ServiceLocatorInterface $serviceLocator)
    {
        if ($this->config !== null) {
            return $this->config;
        }

        if (!$serviceLocator->has('Config')) {
            $this->config = array();
            return $this->config;
        }

        $config = $serviceLocator->get('Config');
        if (!isset($config[$this->configKey])
            || !is_array($config[$this->configKey])
        ) {
            $this->config = array();
            return $this->config;
        }

        $this->config = $config[$this->configKey];
        return $this->config;
    }
}
