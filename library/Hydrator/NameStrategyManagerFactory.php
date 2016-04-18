<?php

namespace ImgMan\Hydrator;

use ImgMan\Storage\Adapter\Cdn\Amazon\ClientAbstractFactory;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\NamingStrategy\NamingStrategyInterface;

class NameStrategyManagerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $objectConfig = [];
        if (isset($config['imgman']) && isset($config['imgman']['name_strategy_manager'])) {
            $config = $config['imgman']['name_strategy_manager'];
        }
        return new NameStrategyManager(new Config($objectConfig));
    }
}