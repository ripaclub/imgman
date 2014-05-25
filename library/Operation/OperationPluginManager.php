<?php

namespace ImgManLibrary\Operation;

use Zend\ServiceManager\AbstractPluginManager;

class OperationPluginManager extends AbstractPluginManager
{
    /**
     * @param mixed $plugin
     * @throws Exception\InvalidHelperException
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof Helper\HelperInterface) {
            // we're okay
            return;
        }

        throw new Exception\InvalidHelperException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Helper\HelperInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }

} 