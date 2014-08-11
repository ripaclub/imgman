<?php
namespace ImgManLibrary\Operation;

use Zend\ServiceManager\AbstractPluginManager;

trait PluginManagerAwareTrait
{
    protected $pluginManager = null;

    /**
     * @param AbstractPluginManager $pluginManager
     * @return $this
     */
    public function setPluginManager(AbstractPluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
        return $this;
    }

    /**
     * @return AbstractPluginManager
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }
}