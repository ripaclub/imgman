<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 17.36
 */

namespace ImgManLibraryTest\Service;

use ImgManLibraryTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager;

class ServiceFactoryTest extends ImageManagerTestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $config = array(
            'imgManServices' => array(
                'service\1' => array(
                    'adapter' => 'ImgManLibrary\Core\Adapter\ImagickAdapter',
                    'storage' => 'ImgManLibrary\Storage\StorageImplement',
                    'type'    => 'ImgManLibraryTest\Service\TestAsset\ServiceAsset'
                ),
                'service\2' => array(
                    'adapter' => 'ImgManLibrary\Core\Adapter\ImagickAdapter',
                    'storage' => 'ImgManLibrary\Storage\StorageImplement',
                ),
                'service\notExist\storage' => array(
                    'adapter' => 'ImgManLibrary\Core\Adapter\ImagickAdapter',
                    'storage' => 'test',
                ),
                'service\wrong\storage' => array(
                    'adapter' => 'ImgManLibrary\Storage\ImagickAdapter',
                    'storage' => null,
                ),
            ),
        );

        $sm = $this->serviceManager = new ServiceManager\ServiceManager(
                new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgManLibrary\Service\ServiceFactory',
                    )
                )
            )
        );

        $sm->setService('Config', $config);
    }

    public function testHasService()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertTrue($serviceLocator->has('service\1'));
    }

    public function testCreateService()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertInstanceOf('ImgManLibrary\Service\ServiceInterface', $serviceA = $serviceLocator->get('service\1'));
    }

    public function testNotExistIntefaceService()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertFalse($serviceLocator->has('service\notExist\storage'));
    }

    public function testNullInterfaceService()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertFalse($serviceLocator->has('service\wrong\storage'));
    }

    public function testEmptyConfigService()
    {
        $sm = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                'abstract_factories' => array(
                    'ImgManLibrary\Service\ServiceFactory',
                )
            ))
        );

        $this->assertFalse($sm->has('service\1'));
    }

    /**
     * @depends testHasService
     */
    public function testConstractParameterService()
    {
        /* @var \ImgManLibraryTest\Service\TestAsset\ServiceAsset $service1 */
        $service1 = $this->serviceManager->get('service\1');

       var_dump(get_class($service1->getAdapter()));
        var_dump(get_class($service1->getStorage()));
        var_dump(get_class($service1->getStorage()));
    }
} 