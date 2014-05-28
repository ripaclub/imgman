<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 19/05/14
 * Time: 13.11
 */

namespace ImgManLibrary\Service;

use ImgManLibrary\Core\Adapter\AdapterInterface;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

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
    protected $serviceName = 'ImgManLibrary\Service\ServiceImplement';

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
            // Storage check
            isset($config[$requestedName]['storage']) &&
            is_string($config[$requestedName]['storage']) &&
            $this->isInterface('\ImgManLibrary\Storage\StorageInterface', $config[$requestedName]['storage']) &&
            // Storage check
            isset($config[$requestedName]['adapter']) &&
            is_string($config[$requestedName]['adapter']) &&
            $this->isInterface('\ImgManLibrary\Core\Adapter\AdapterInterface', $config[$requestedName]['adapter'])
        );
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $this->getConfig($serviceLocator)[$requestedName];

        $adapter = new $config['adapter']();
        $storage = new $config['storage']();

        $class = $this->serviceName;
        if (isset($config['type'])
            && is_string($config['type'])
            && !empty($config['type'])
        ) {
            if ($this->isInterface('ImgManLibrary\Service\ServiceInterface', $config['type'])) {
                $class = $config['type'];
            }
        }

        $service = new $class($this->createPluginManager($adapter), $adapter, $storage);

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

    protected function createPluginManager(AdapterInterface $adapter)
    {
        $config = array(
            'factories' => array(
                'operationManager' => 'ImgManLibrary\Operation\OperationHelperManagerFactory',
            ),
            'invokables' => array(
                'imgManAdapter' => get_class($adapter),
            ),
        );

        $sm = $this->serviceManager = new ServiceManager(
            new ServiceManagerConfig($config)
        );

        return $operationManager = $sm->get('operationManager');
    }

    /**
     * @param $nameInterface
     * @param null $class
     * @return bool
     */
    protected function isInterface($nameInterface, $class)
    {
        try {
             $reflection = new \ReflectionClass($class);
             return $reflection->implementsInterface($nameInterface);
        }
        catch (\Exception $e) {
            return false;
        }
    }
} 