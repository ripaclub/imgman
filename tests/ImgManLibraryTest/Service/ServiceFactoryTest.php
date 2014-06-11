<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 17.36
 */

namespace ImgManLibraryTest\Service;

use ImgManLibrary\Entity\ImageEntity;
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
        $this->image = new ImageEntity(__DIR__ . '/../Entity/img/test.jpg');

        $config = array(
            'imgManServices' => array(
                'ImgMan\service1' => array(
                    'adapter'       => 'ImgMan\service\Adapter',
                    'storage'       => 'ImgMan\service\Storage',
                    'type'          => 'ImgMan\service\Type',
                    'pluginManager' => 'ImgMan\pluginManager',
                ),
                'ImgMan\service2' => array(
                    'adapter' => 'ImgMan\service\Adapter',
                    'storage' => 'ImgMan\service1\Storage',
                ),
                'ImgMan\serviceNotExitStorage' => array(
                    'adapter' => 'ImgMan\service\Adapter',
                    'storage' => 'test',
                ),
                'ImgMan\serviceWrongStorage' => array(
                    'adapter' => 'ImgMan\service\Adapter',
                    'storage' => null,
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
            'imgManMongodb' => array(
                'MongoDb' => array(
                    'database' => 'testImgMan'
                )
            ),
            'imgManMongoCollection' => array(
                'ImgMan\TestCollection' => array(
                    'collection' => 'testImage',
                    'database' => 'MongoDb'
                )
            )
        );

        $this->serviceManager = new ServiceManager\ServiceManager(
                new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgManLibrary\Service\ServiceFactory',
                        'ImgManLibrary\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
                        'ImgManLibrary\Storage\Adapter\Mongo\MongoCollectionAbstractServiceFactory',
                    ),
                    'factories' => array(
                        'ImgMan\pluginManager' => 'ImgManLibrary\Operation\OperationHelperManagerFactory',
                    ),
                    'invokables' => array(
                        // ImgMan storage
                        'ImgMan\service\Storage' => 'ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter',
                        // ImgMan adapter
                        'ImgMan\service\Adapter' => 'ImgManLibrary\Core\Adapter\ImagickAdapter',
                        // ImgMan type
                        'ImgMan\service\Type' => 'ImgManLibraryTest\Service\TestAsset\ServiceAsset'
                    ),
                    'shared' => array(
                  //      'ImgMan\service\Adapter' => false,
                        'ImgMan\service\Storage' => false,
                        'ImgMan\service\Type'    => false,
                        'ImgMan\pluginManager'   => false
                    ),
                )
            )
        );

        $this->serviceManager->setService('Config', $config);
    }

    public function __testHasService()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertTrue($serviceLocator->has('ImgMan\service1'));
    }

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

    /**
     * @depends testHasService
     */
    public function __testConstractParameterService()
    {
        /* @var \ImgManLibraryTest\Service\TestAsset\ServiceAsset $service1 */
        $service1 = $this->serviceManager->get('ImgMan\service1');

        $this->assertInstanceOf('ImgManLibrary\Core\CoreInterface', $service1->getAdapter());
        $this->assertInstanceOf('ImgManLibrary\Storage\StorageInterface', $service1->getStorage());
        $this->assertInstanceOf('Zend\ServiceManager\AbstractPluginManager', $service1->getPluginManager());
    }

    /**
     * @depends testHasService
     */
    public function __testConstractRedentionService()
    {
        /* @var \ImgManLibraryTest\Service\TestAsset\ServiceAsset $service */
        $service = $this->serviceManager->get('ImgMan\serviceRendition');
        $this->assertNotEmpty($service->getRenditions());
    }

    public function testGrabService()
    {
        /* @var \ImgManLibraryTest\Service\TestAsset\ServiceAsset $service */
        $service = $this->serviceManager->get('ImgMan\serviceRendition');
        $service->grab($this->image, 'test/test/test');
    }
} 