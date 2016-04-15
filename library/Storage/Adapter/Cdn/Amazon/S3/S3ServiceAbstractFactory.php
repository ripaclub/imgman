<?php
namespace ImgMan\Storage\Adapter\Cdn\Amazon\S3;

use Aws\AwsClient;
use Aws\S3\S3Client;
use Aws\Sdk;
use ImgMan\Storage\Adapter\Cdn\Amazon\ClientManager;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ClientAbstractFactory
 */
class S3ServiceAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Config Key
     * @var string
     */
    protected $configKey = 'imgman_amazon_s3_service';

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
            && $serviceLocator->has(ClientManager::class)
            && isset($config[$requestedName]['client'])
            && is_string($config[$requestedName]['client'])
            && $serviceLocator->has(ClientManager::class)
            && $serviceLocator->get(ClientManager::class)->has($config[$requestedName]['client'])
            && isset($config[$requestedName]['bucket'])
            && is_string($config[$requestedName]['bucket'])
            && !empty($config[$requestedName]['bucket'])
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
        /** @var $sdk Sdk */
        $adapter = new S3Service($serviceLocator->get(ClientManager::class)->get($config['client']));
        return $adapter->setBucket($config['bucket']);
    }

    protected function getClientConfig($config)
    {
        $awsConfig = [
            'credentials' => [
                'key' => $config['key'],
                'secret' => $config['secret']
            ],
            'region' => $config['region'],
            'version' => $config['version']
        ];

        return new Sdk($config);
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