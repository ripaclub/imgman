<?php
namespace ImgManLibrary\Operation;

use Zend\ServiceManager\AbstractPluginManager;

trait PluginManagerAwareTrait
{
    protected $pluginManager;

    /**
     * @param mixed $pluginManager
     */
    public function setPluginManager(AbstractPluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    /**
     * @return mixed
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }
}