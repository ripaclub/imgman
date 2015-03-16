<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Mongo;

use ImgMan\Storage\StorageInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class MongoAdapterAbstractServiceFactory
 */
class MongoAdapterAbstractServiceFactory implements AbstractFactoryInterface
{
    /**
     * Config Key
     * @var string
     */
    protected $configKey = 'imgman_adapter_mongo';

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
        /** @var $mongoDb \MongoDB */
        $mongoDb = $serviceLocator->get($config['database']);
        $mongoCollection = new \MongoCollection($mongoDb, $config['collection']);
        $adapter = new MongoAdapter();
        if (isset($config['identifier'])) {
            $adapter->setIdentifier($config['identifier']);
        }
        return $adapter->setMongoCollection($mongoCollection);
    }
}
