<?php

namespace ImgMan\Hydrator;

use ImgMan\Storage\Adapter\Cdn\Amazon\ClientAbstractFactory;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\Exception;
use Zend\Stdlib\Hydrator\NamingStrategy\NamingStrategyInterface;

class NameStrategyManager extends AbstractPluginManager
{
    protected $invokableClasses = [
        'default' => 'ImgMan\Hydrator\DefaultNamingStrategy'
    ];

    public function validatePlugin($plugin)
    {

        if (!($plugin instanceof NamingStrategyInterface)) {

            throw new Exception\RuntimeException(sprintf(
                'Type "%s" is invalid; must be an object',
                gettype($plugin)
            ));
        }
    }

}