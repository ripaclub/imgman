<?php
/**
 * Matryoshka Wrappers
 *
 * @link        https://github.com/ripaclub/matryoshka
 * @copyright   Copyright (c) 2014, Ripa Club
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace ImgManLibrary\Storage\Adapter\Mongo;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ImgManLibrary\Storage\StorageInterface;

/**
 * Class MongoCollectionAbstractServiceFactory
 */
class MongoCollectionAbstractServiceFactory implements AbstractFactoryInterface
{

    /**
     * Config Key
     * @var string
     */
    protected $configKey = 'imgManMongoAdapter';

    /**
     * Config
     * @var array
     */
    protected $config;

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return boolean
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $this->getConfig($serviceLocator);
        if (empty($config)) {
            return false;
        }

        return (
            isset($config[$requestedName])
            && is_array($config[$requestedName])
            && !empty($config[$requestedName])
            && isset($config[$requestedName]['database'])
            && is_string($config[$requestedName]['database'])
            && !empty($config[$requestedName]['database'])
            && $serviceLocator->has($config[$requestedName]['database'])
            && isset($config[$requestedName]['collection'])
            && is_string($config[$requestedName]['collection'])
            && !empty($config[$requestedName]['collection'])
        );
    }

    /**
     * Get mongo configuration, if any
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
        if (!isset($config[$this->configKey])
        || !is_array($config[$this->configKey])
        ) {
            $this->config = [];
            return $this->config;
        }

        $this->config = $config[$this->configKey];
        return $this->config;
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return StorageInterface
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $this->getConfig($serviceLocator)[$requestedName];

        $mongoCollection = new \MongoCollection($serviceLocator->get($config['database']), $config['collection']);
        $adapter = new MongoAdapter();
        return $adapter->setMongoCollection($mongoCollection);
    }
}
