<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage\Adapter\Mongo;

use ImgManTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager;

/**
 * Class MongoAdapterAbstractServiceFactoryTest
 */
class MongoAdapterAbstractServiceFactoryTest extends ImageManagerTestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $config = [
            'imgman_adapter_mongo' => [
                'ImgMan\Storage\Mongo' => [
                    'collection' => 'image_test',
                    'database' => 'MongoDb'
                ],
                'ImgMan\Storage\MongoEmpty' => [],
            ],
            'imgman_mongodb' => [
                'MongoDb' => [
                    'database' => 'testImgMan'
                ],
            ],
        ];
        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(
                [
                    'abstract_factories' => [
                        'ImgMan\Storage\Adapter\Mongo\MongoAdapterAbstractServiceFactory',
                        'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory'
                    ],
                ]
            )
        );

        $this->serviceManager->setService('Config', $config);
    }

    public function testMongoAdapeterAbstractServiceFactor()
    {
        $this->assertTrue($this->serviceManager->has('ImgMan\Storage\Mongo'));
        $this->assertInstanceOf(
            'ImgMan\Storage\Adapter\Mongo\MongoAdapter',
            $this->serviceManager->get('ImgMan\Storage\Mongo')
        );
        $this->assertFalse($this->serviceManager->has('ImgMan\Storage\MongoEmpty'));
    }

    public function testMongoAdapterAbstractServiceFactorEmptyConfig()
    {
         $this->serviceManager = new ServiceManager\ServiceManager(
             new ServiceManagerConfig(
                 [
                      'abstract_factories' => [
                          'ImgMan\Storage\Adapter\Mongo\MongoAdapterAbstractServiceFactory',
                          'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory'
                      ],
                 ]
             )
         );
         $this->assertFalse($this->serviceManager->has('ImgMan\Storage\Mongo'));

         $this->serviceManager = new ServiceManager\ServiceManager(
             new ServiceManagerConfig(
                 [
                    'abstract_factories' => [
                        'ImgMan\Storage\Adapter\Mongo\MongoAdapterAbstractServiceFactory',
                        'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory'
                    ],
                ]
             )
         );
        $this->serviceManager->setService('Config', []);
        $this->assertFalse($this->serviceManager->has('ImgMan\Storage\Mongo'));
    }
}
