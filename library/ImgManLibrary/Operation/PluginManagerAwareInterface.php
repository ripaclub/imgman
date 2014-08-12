<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 30/05/14
 * Time: 18.09
 */

namespace ImgManLibrary\Operation;

use Zend\ServiceManager\AbstractPluginManager;

interface PluginManagerAwareInterface
{
    /**
     * @return AbstractPluginManager
     */
    public function getPluginManager();

    /**
     * @param AbstractPluginManager $pluginManager
     * @return mixed
     */
    public function setPluginManager(AbstractPluginManager $pluginManager);
} 