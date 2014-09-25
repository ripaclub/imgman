<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Operation;

use ImgManTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager;

/**
 * Class PluginManagerTest
 */
class PluginManagerTest extends ImageManagerTestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $config = [
            'factories' => [
                'ImgMan\Operation\HelperPluginManager' => 'ImgMan\Operation\HelperPluginManagerFactory',
            ],
            'invokables' => [
                'ImgMan\Operation\Helper\FitIn' => 'ImgMan\Operation\Helper\FitIn',
                'imgManAdapter' => 'ImgMan\Core\Adapter\ImagickAdapter'
            ],
        ];

        $sm = $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig($config)
        );

        $sm->setService('Config', $config);
    }

    public function testHelperPluginManagerConfig()
    {
        /** @var \ImgMan\Operation\HelperPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('ImgMan\Operation\HelperPluginManager');
        $this->assertInstanceOf('ImgMan\Operation\HelperPluginManager', $pluginManager);
    }


    public function testHelperPluginManagerHelper()
    {
        /** @var \ImgMan\Operation\HelperPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('ImgMan\Operation\HelperPluginManager');
        $pluginManager->get('fitIn');
        $pluginManager->setAdapter($this->getMock('ImgMan\Core\CoreInterface'));
        $pluginManager->get('fitOut');
        $this->assertInstanceOf('ImgMan\Core\CoreInterface', $pluginManager->getAdapter());
    }

    /**
     * @expectedException \ImgMan\Operation\Exception\InvalidHelperException
     */
    public function testHelperPluginManagerValidatePlugin()
    {
        /** @var \ImgMan\Operation\HelperPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('ImgMan\Operation\HelperPluginManager');
        $pluginManager->setService($this->getMock('MockPlugin'), 'TestPlugin');
    }
}
