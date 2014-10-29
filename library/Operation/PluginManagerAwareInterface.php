<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation;

use Zend\ServiceManager\AbstractPluginManager;

/**
 * Interface PluginManagerAwareInterface
 */
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
