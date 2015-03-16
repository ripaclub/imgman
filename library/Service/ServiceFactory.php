<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Service;

use ImgMan\Core\CoreInterface;
use ImgMan\Operation\HelperPluginManager;
use ImgMan\Storage\StorageInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ServiceFactory
 */
class ServiceFactory implements AbstractFactoryInterface
{
    /**
     * Config Key
     * @var string
     */
    protected $configKey = 'imgman_services';

    /**
     * Default service class name
     *
     * @var string
     */
    protected $serviceName = 'ImgMan\Service\ImageService';

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
                    isset($config[$requestedName]['helper_manager']) &&
                    is_string($config[$requestedName]['helper_manager']) &&
                    $serviceLocator->has($config[$requestedName]['helper_manager'])
                ) || (
                    // Check not adapter and PluginManager
                    !isset($config[$requestedName]['adapter']) &&
                    !isset($config[$requestedName]['helper_manager'])
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
        /* @var $service ServiceInterface */
        $service = new $this->serviceName();
        if (isset($config['type']) && is_string($config['type']) &&
            !empty($config['type']) && $serviceLocator->has($config['type'])
        ) {

            $service = $serviceLocator->get($config['type']);
        }
        // Storage
        /** @var $storage StorageInterface */
        $storage = $serviceLocator->get($config['storage']);
        /** @var $adapter CoreInterface */
        $adapter = null;
        /** @var $helperManager HelperPluginManager */
        $helperManager = null;
        // Adapter and pluginManager
        if (isset($config['helper_manager']) && isset($config['adapter'])) {
            $adapter = $serviceLocator->get($config['adapter']);
            $helperManager = $serviceLocator->get($config['helper_manager']);
            $helperManager->setAdapter($adapter);
        }

        if (isset($config['regex_identifier'])) {
            $service->setRegExIdentifier($config['regex_identifier']);
        }

        /* @var ServiceInterface $service */
        $service->setStorage($storage);
        if ($adapter) {
            $service->setAdapter($adapter);
        }
        if ($helperManager) {
            $service->setPluginManager($helperManager);
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
            $this->config = [];
            return $this->config;
        }

        $config = $serviceLocator->get('Config');
        if (!isset($config[$this->configKey]) || !is_array($config[$this->configKey])) {
            $this->config = [];
            return $this->config;
        }

        $this->config = $config[$this->configKey];
        return $this->config;
    }
}
