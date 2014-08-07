<?php
namespace ImgManLibraryTest\Service;

use ImgManLibrary\Image\ImageContainer;
use ImgManLibrary\Service\ServiceImplement;
use ImgManLibraryTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager;

class __ServiceFactoryTest extends ImageManagerTestCase
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
/**
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
 * */

        $serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig([
                    'abstract_factories' => [
                        // Load abstract service
                        'ImgManLibrary\Service\ServiceFactory',
                        // Load abstract mongo db connection
                        'ImgManLibrary\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
                        // Load abstract mongo collection
                        'ImgManLibrary\Storage\Adapter\Mongo\MongoCollectionAbstractServiceFactory',
                    ],
                    'factories' => [
                        // Load operation plugin manager
                        'ImgMan\PluginManager' => 'ImgManLibrary\Operation\OperationHelperManagerFactory',
                    ],
                    'invokables' => [
                        // Load adapter
                        'ImgMan\Adapter\Imagick'  => 'ImgManLibrary\Core\Adapter\ImagickAdapter',
                    ],
                ]
            )
        );


        $config = [
            'imgManMongodb' => [
                'MongoDb' => [
                    'database' => 'imgManStorage'
                ]
            ],
            'imgManMongoAdapter' => [
                'ImgMan\Storage\Mongo' => [
                    'collection' => 'image_test',
                    'database' => 'MongoDb'
                ]
            ],
                'imgManServices' => [
                    'ImgMan\Service\First' => [
                        'adapter'       => 'ImgMan\Adapter\Imagick',
                        'storage'       => 'ImgMan\Storage\Mongo',
                        'pluginManager' => 'ImgMan\PluginManager',
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
                    ]
                ]
        ];

        $serviceManager->setService('Config', $config);

        var_dump($serviceManager->has('ImgMan\Service\First'));
    }

    public function testServiceFactoryGet()
    {

    }
} 