<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Service;

use ImgMan\Image\ImageContainer;
use ImgMan\Service\ServiceImplement;
use ImgManTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager;

class ServiceFactoryTest extends ImageManagerTestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @var \ImgMan\Entity\ImageEntity
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
                        'ImgMan\Service\ServiceFactory',
                    ),
                )
            )
        );

        $this->serviceManager->setService('Config', $config);
        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $this->serviceManager->setService('ImgMan\Service\Adapter', $adapter);
        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $this->serviceManager->setService('ImgMan\Service\Storage', $storage);
        $pluginManager =  $this->getMock('ImgMan\Operation\OperationPluginManager');
        $this->serviceManager->setService('ImgMan\PluginManager', $pluginManager);
        $type = $this->getMockForAbstractClass('ImgMan\Service\AbstractService');
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
                        'ImgMan\Service\ServiceFactory',
                    ),
                )
            )
        );

        $this->assertFalse($this->serviceManager->has('ImgMan\Service\Test2'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgMan\Service\ServiceFactory',
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
        $this->assertInstanceOf('ImgMan\Service\AbstractService', $serviceLocator->get('ImgMan\Service\Test1'));
        $this->assertInstanceOf('ImgMan\Service\AbstractService', $serviceLocator->get('ImgMan\Service\Test2'));
    }
}
