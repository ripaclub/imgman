<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 27/05/14
 * Time: 11.22
 */

namespace ImgManLibraryTest\Operation;

use ImgManLibrary\Core\CoreInterface;
use ImgManLibraryTest\ImageManagerTestCase;

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
                'operationManager' => 'ImgManLibrary\Operation\OperationHelperManagerFactory',
            ),
            'invokables' => array(
                'ImgManLibrary\Operation\OperationPluginManager' => 'ImgManLibrary\Operation\OperationPluginManager',
                'ImgManLibrary\Operation\Helper\FitIn' => 'ImgManLibrary\Operation\Helper\FitIn',
                'imgManAdapter' => 'ImgManLibrary\Core\Adapter\ImagickAdapter'
            ),
        );

        $sm = $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig($config)
        );

        $sm->setService('Config', $config);
    }

    public function testOperationPluginManagerConfig()
    {
        /** @var \ImgManLibrary\Operation\OperationPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('operationManager');
        $this->assertInstanceOf('ImgManLibrary\Operation\OperationPluginManager', $pluginManager);
    }


    public function testOperationPluginManagerHelper()
    {
        /** @var \ImgManLibrary\Operation\OperationPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('operationManager');
        $pluginManager->get('fitIn');
        $pluginManager->setAdapter($this->getMock('ImgManLibrary\Core\CoreInterface'));
        $pluginManager->get('fitOut');
        $this->assertInstanceOf('ImgManLibrary\Core\CoreInterface', $pluginManager->getAdapter());
    }

    /**
     * @expectedException \ImgManLibrary\Operation\Exception\InvalidHelperException
     */
    public function testOperationPluginManagerValidatePlugin()
    {
        /** @var \ImgManLibrary\Operation\OperationPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('operationManager');
        $pluginManager->setService($this->getMock('MockPlugin'), 'TestPlugin');
    }
} 