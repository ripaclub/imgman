<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn;

use ImgMan\Hydrator\NameStrategyManager;
use ImgMan\Storage\StorageInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AmazonAdapterAbstractFactory
 */
class AmazonAdapterAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Config Key
     * @var string
     */
    protected $configKey = 'imgman_amazon_adapter';

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
            && isset($config[$requestedName]['s3_client'])
            && is_string($config[$requestedName]['s3_client'])
            && $serviceLocator->has($config[$requestedName]['s3_client'])
            && isset($config[$requestedName]['cloud_front_client'])
            && is_string($config[$requestedName]['cloud_front_client'])
            && $serviceLocator->has($config[$requestedName]['cloud_front_client'])
            && isset($config[$requestedName]['name_strategy'])
            && is_string($config[$requestedName]['name_strategy'])
            && $serviceLocator->has(NameStrategyManager::class)
            && $serviceLocator->get(NameStrategyManager::class)->has($config[$requestedName]['name_strategy'])
        );
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

        $storage = new AmazonAdapter(
             $serviceLocator->get($config['s3_client']),
             $serviceLocator->get($config['cloud_front_client'])
        );

        $nameStrategyConfig = [];
        if (isset($config['name_strategy_config'])) {
            $nameStrategyConfig = $config['name_strategy_config'];
        }
        return $storage->setNameStrategy(
            $serviceLocator->get(NameStrategyManager::class)->get(($config['name_strategy']), $nameStrategyConfig)
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
}