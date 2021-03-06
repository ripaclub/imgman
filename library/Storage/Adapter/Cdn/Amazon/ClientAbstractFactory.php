<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn\Amazon;

use Aws\Sdk;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ClientAbstractFactory
 */
class ClientAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Config Key
     * @var string
     */
    protected $configKey = 'imgman_amazon_client';

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
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $config = $this->getConfig($serviceLocator);
        if (empty($config)) {
            return false;
        }

        return (
            isset($config[$requestedName])
            && is_array($config[$requestedName])
            && !empty($config[$requestedName])
            && isset($config[$requestedName]['region'])
            && is_string($config[$requestedName]['region'])
            && !empty($config[$requestedName]['region'])
            && isset($config[$requestedName]['secret'])
            && is_string($config[$requestedName]['secret'])
            && !empty($config[$requestedName]['secret'])
            && isset($config[$requestedName]['key'])
            && is_string($config[$requestedName]['key'])
            && !empty($config[$requestedName]['key'])
            && isset($config[$requestedName]['version'])
            && is_string($config[$requestedName]['version'])
            && !empty($config[$requestedName]['version'])
            && isset($config[$requestedName]['name'])
            && is_string($config[$requestedName]['name'])
            && !empty($config[$requestedName]['name'])
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
        return $this->getClientFromConfig($config);
    }

    protected function getClientFromConfig($config)
    {
        $awsConfig = [
            'credentials' => [
                'key' => $config['key'],
                'secret' => $config['secret']
            ],
            'region' => $config['region'],
            'version' => $config['version']
        ];

        $sdk = new Sdk();
        return $sdk->createClient($config['name'], $awsConfig);
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