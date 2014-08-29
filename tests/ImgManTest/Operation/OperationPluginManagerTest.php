<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Operation;

use ImgMan\Core\CoreInterface;
use ImgManTest\ImageManagerTestCase;

use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager;

class OperationPluginManagerTest extends ImageManagerTestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $config = array(
            'factories' => array(
                'operationManager' => 'ImgMan\Operation\OperationHelperManagerFactory',
            ),
            'invokables' => array(
                'ImgMan\Operation\OperationPluginManager' => 'ImgMan\Operation\OperationPluginManager',
                'ImgMan\Operation\Helper\FitIn' => 'ImgMan\Operation\Helper\FitIn',
                'imgManAdapter' => 'ImgMan\Core\Adapter\ImagickAdapter'
            ),
        );

        $sm = $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig($config)
        );

        $sm->setService('Config', $config);
    }

    public function testOperationPluginManagerConfig()
    {
        /** @var \ImgMan\Operation\OperationPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('operationManager');
        $this->assertInstanceOf('ImgMan\Operation\OperationPluginManager', $pluginManager);
    }


    public function testOperationPluginManagerHelper()
    {
        /** @var \ImgMan\Operation\OperationPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('operationManager');
        $pluginManager->get('fitIn');
        $pluginManager->setAdapter($this->getMock('ImgMan\Core\CoreInterface'));
        $pluginManager->get('fitOut');
        $this->assertInstanceOf('ImgMan\Core\CoreInterface', $pluginManager->getAdapter());
    }

    /**
     * @expectedException \ImgMan\Operation\Exception\InvalidHelperException
     */
    public function testOperationPluginManagerValidatePlugin()
    {
        /** @var \ImgMan\Operation\OperationPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('operationManager');
        $pluginManager->setService($this->getMock('MockPlugin'), 'TestPlugin');
    }
}
