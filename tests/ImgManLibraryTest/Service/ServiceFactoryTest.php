<?php
namespace ImgManLibraryTest\Service;

use ImgManLibrary\Image\ImageContainer;
use ImgManLibrary\Service\ServiceImplement;
use ImgManLibraryTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager;

class ServiceFactoryTest extends ImageManagerTestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @var \ImgManLibrary\Entity\ImageEntity
     */
    protected $image;

    public function setUp()
    {
        $this->image = new ImageContainer(__DIR__ . '/../Image/img/test.jpg');

        $config = array(
            'imgManServices' => array(
                'ImgMan\Service\Test0' => array(),
                'ImgMan\Service\Test1' => array(
                    'storage'       => 'ImgMan\Service\Storage'
                ),
                'ImgMan\Service\Test2' => array(
                    'adapter'       => 'ImgMan\Service\Adapter',
                    'storage'       => 'ImgMan\Service\Storage',
                    'pluginManager' => 'ImgMan\PluginManager',
                    'type'          => 'ImgMan\Service\Type',
                    'renditions' => array(
                        'thumb' => array(
                            'resize' => array(
                                'width'  => 200,
                                'height' => 200
                            )
                        ),
                    )
                ),
                'ImgMan\serviceRendition' => array(
                    'adapter' => 'ImgMan\service\Adapter',
                    'storage' => 'ImgMan\TestCollection',
                    'type'    => 'ImgMan\service\Type',
                    'pluginManager' => 'ImgMan\pluginManager',
                    'renditions' => array(
                        'thumb' => array(
                            'resize' => array(
                                'width'  => 200,
                                'height' => 200
                            )
                        ),
                        'thumbMaxi' => array(
                            'resize' => array(
                                'width'  => 400,
                                'height' => 400
                            )
                        )
                    ),
                ),
            ),
        );

        $this->serviceManager = new ServiceManager\ServiceManager(
                new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgManLibrary\Service\ServiceFactory',
                    ),
                )
            )
        );

        $this->serviceManager->setService('Config', $config);
        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');
        $this->serviceManager->setService('ImgMan\Service\Adapter', $adapter);
        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $this->serviceManager->setService('ImgMan\Service\Storage', $storage);
        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');
        $this->serviceManager->setService('ImgMan\PluginManager', $pluginManager);
        $type = $this->getMockForAbstractClass('ImgManLibrary\Service\AbstractService');
        $this->serviceManager->setService('ImgMan\Service\Type', $type);
    }

    public function testServiceFactoryHas()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertFalse($serviceLocator->has('ImgMan\Service\Test0'));
        $this->assertTrue($serviceLocator->has('ImgMan\Service\Test1'));
        $this->assertTrue($serviceLocator->has('ImgMan\Service\Test2'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgManLibrary\Service\ServiceFactory',
                    ),
                )
            )
        );

        $this->assertFalse($this->serviceManager->has('ImgMan\Service\Test2'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgManLibrary\Service\ServiceFactory',
                    ),
                )
            )
        );

        $this->serviceManager->setService('Config', array());
        $this->assertFalse($this->serviceManager->has('ImgMan\Service\Test2'));
    }

    public function testServiceFactoryGet()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertInstanceOf('ImgManLibrary\Service\AbstractService', $serviceLocator->get('ImgMan\Service\Test1'));
        $this->assertInstanceOf('ImgManLibrary\Service\AbstractService', $serviceLocator->get('ImgMan\Service\Test2'));
    }

    /*
    public function __testCreateService()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertInstanceOf('ImgManLibrary\Service\ServiceInterface', $serviceLocator->get('ImgMan\service1'));
    }

    public function __testNotExistIntefaceService()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertFalse($serviceLocator->has('ImgMan\serviceNotExitStorage'));
    }

    public function __testNullInterfaceService()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertFalse($serviceLocator->has('ImgMan\serviceWrongStorage'));
    }

    public function __testEmptyConfigService()
    {
        $sm = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                'abstract_factories' => array(
                    'ImgManLibrary\Service\ServiceFactory',
                )
            ))
        );

        $this->assertFalse($sm->has('ImgMan\service1'));
    }


    public function __testConstractParameterService()
    {

        $service1 = $this->serviceManager->get('ImgMan\service1');

        $this->assertInstanceOf('ImgManLibrary\Core\CoreInterface', $service1->getAdapter());
        $this->assertInstanceOf('ImgManLibrary\Storage\StorageInterface', $service1->getStorage());
        $this->assertInstanceOf('Zend\ServiceManager\AbstractPluginManager', $service1->getPluginManager());
    }

    public function __testConstractRedentionService()
    {

        $service = $this->serviceManager->get('ImgMan\serviceRendition');
        $this->assertNotEmpty($service->getRenditions());
    }

    public function __testGrabService()
    {
        $service = $this->serviceManager->get('ImgMan\serviceRendition');
        $service->grab($this->image, 'test/test/test');
    }

    public function __testDeleteService()
    {
        $service = $this->serviceManager->get('ImgMan\serviceRendition');
        $service->grab($this->image, 'test/test/test');
    }
    */
} 