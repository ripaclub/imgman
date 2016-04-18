<?php
namespace ImgMan\Storage\Adapter\Cdn\Amazon;

use Aws\AwsClientInterface;
use ImgMan\Storage\Adapter\Cdn\Amazon\S3\S3ClientAbstractFactory;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ClientManager
 */
class ClientManagerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $objectConfig = [];
        if (isset($config['imgman']) && isset($config['imgman']['amazon_client_manager'])) {
            $config = $config['imgman']['amazon_client_manager'];
        }
        return new ClientManager(new Config($objectConfig));
    }
}