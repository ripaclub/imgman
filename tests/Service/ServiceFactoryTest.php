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
use ImgManTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ServiceFactoryTest
 */
class ServiceFactoryTest extends ImageManagerTestCase
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var ImageContainer
     */
    protected $image;

    public function setUp()
    {
        if (!extension_loaded('imagick')) {
            $this->markTestSkipped(
                'The imagick extension is not available.'
            );
        }

        $this->image = new ImageContainer(__DIR__ . '/../Image/img/test.jpg');

        $config = [
            'imgman_services' => [
                'ImgMan\Service\Test0' => [],
                'ImgMan\Service\Test1' => [
                    'storage'       => 'ImgMan\Service\Storage'
                ],
                'ImgMan\Service\Test2' => [
                    'adapter'       => 'ImgMan\Service\Adapter',
                    'storage'       => 'ImgMan\Service\Storage',
                    'helper_manager' => 'ImgMan\PluginManager',
                    'type'          => 'ImgMan\Service\Type',
                    'renditions' => [
                        'thumb' => [
                            'resize' => [
                                'width'  => 200,
                                'height' => 200
                            ]
                        ],
                    ]
                ],
                'ImgMan\serviceRendition' => [
                    'adapter' => 'ImgMan\service\Adapter',
                    'storage' => 'ImgMan\TestCollection',
                    'type'    => 'ImgMan\service\Type',
                    'pluginManager' => 'ImgMan\pluginManager',
                    'renditions' => [
                        'thumb' => [
                            'resize' => [
                                'width'  => 200,
                                'height' => 200
                            ]
                        ],
                        'thumbMaxi' => [
                            'resize' => [
                                'width'  => 400,
                                'height' => 400
                            ]
                        ]
                    ],
                ],
            ],
        ];

        $this->serviceManager = new ServiceManager(
            new ServiceManagerConfig(
                [
                    'abstract_factories' => [
                        'ImgMan\Service\ServiceFactory',
                    ],
                ]
            )
        );

        $this->serviceManager->setService('Config', $config);
        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $this->serviceManager->setService('ImgMan\Service\Adapter', $adapter);
        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $this->serviceManager->setService('ImgMan\Service\Storage', $storage);
        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');
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

        $this->serviceManager = new ServiceManager(
            new ServiceManagerConfig(
                [
                    'abstract_factories' => [
                        'ImgMan\Service\ServiceFactory',
                    ],
                ]
            )
        );

        $this->assertFalse($this->serviceManager->has('ImgMan\Service\Test2'));

        $this->serviceManager = new ServiceManager(
            new ServiceManagerConfig(
                [
                    'abstract_factories' => [
                        'ImgMan\Service\ServiceFactory',
                    ],
                ]
            )
        );

        $this->serviceManager->setService('Config', []);
        $this->assertFalse($this->serviceManager->has('ImgMan\Service\Test2'));
    }

    public function testServiceFactoryGet()
    {
        $serviceLocator = $this->serviceManager;
        $this->assertInstanceOf('ImgMan\Service\AbstractService', $serviceLocator->get('ImgMan\Service\Test1'));
        $this->assertInstanceOf('ImgMan\Service\AbstractService', $serviceLocator->get('ImgMan\Service\Test2'));
    }
}
