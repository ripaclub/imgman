<?php
namespace ImgManLibrary\Operation;

use Zend\ServiceManager\AbstractPluginManager;

trait PluginManagerAwareTrait
{
    protected $pluginManager = null;

    /**
     * @param mixed $pluginManager
     * @return $this
     */
    public function setPluginManager(AbstractPluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }
}