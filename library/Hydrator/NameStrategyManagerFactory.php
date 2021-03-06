<?php

namespace ImgMan\Hydrator;

use Zend\ServiceManager\Config;
use Zend\ServiceManager\Exception;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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