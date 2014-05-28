<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 27/05/14
 * Time: 11.22
 */

namespace ImgManLibraryTest\Operation;

use ImgManLibraryTest\ImageManagerTestCase;

use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager;

class OperationPluginTest extends ImageManagerTestCase
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

    public function testEntityUrlWrong()
    {
        $d = new \ImgManLibrary\Core\Adapter\ImagickAdapter();
        /** @var \ImgManLibrary\Operation\OperationPluginManager $pluginManager */
        $pluginManager = $this->serviceManager->get('operationManager');
        //var_dump($this->serviceManager->get('fitIn'));
        //var_dump($pluginManager->get('fitIn'));
       //  var_dump($pluginManager->getRegisteredServices());
    }

} 