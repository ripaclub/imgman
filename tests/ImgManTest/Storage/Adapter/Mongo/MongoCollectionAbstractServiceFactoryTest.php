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

class MongoCollectionAbstractServiceFactoryTest extends ImageManagerTestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $config = array(
            'imgManMongoAdapter' => array(
                'ImgMan\Storage\Mongo' => array(
                    'collection' => 'image_test',
                    'database' => 'MongoDb'
                ),
                'ImgMan\Storage\MongoEmpty' => array(
                ),
            ),
            'imgManMongodb' => array(
                'MongoDb' => array(
                    'database' => 'testImgMan'
                ),
            )
        );

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgMan\Storage\Adapter\Mongo\MongoCollectionAbstractServiceFactory',
                        'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory'
                    ),
                )
            )
        );

        $this->serviceManager->setService('Config', $config);
    }

    public function testMongoCollectionAbstractServiceFactor()
    {
        $this->assertTrue($this->serviceManager->has('ImgMan\Storage\Mongo'));
        $this->assertInstanceOf('ImgMan\Storage\Adapter\Mongo\MongoAdapter', $this->serviceManager->get('ImgMan\Storage\Mongo'));

        $this->assertFalse($this->serviceManager->has('ImgMan\Storage\MongoEmpty'));
    }

    public function testMongoCollectionAbstractServiceFactorEmptyConfig()
    {
         $this->serviceManager = new ServiceManager\ServiceManager(
              new ServiceManagerConfig(array(
                      'abstract_factories' => array(
                          'ImgMan\Storage\Adapter\Mongo\MongoCollectionAbstractServiceFactory',
                          'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory'
                      ),
                  )
              )
         );

         $this->assertFalse($this->serviceManager->has('ImgMan\Storage\Mongo'));

         $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgMan\Storage\Adapter\Mongo\MongoCollectionAbstractServiceFactory',
                        'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory'
                    ),
                )
            )
        );


        $this->serviceManager->setService('Config', array());
        $this->assertFalse($this->serviceManager->has('ImgMan\Storage\Mongo'));
    }
} 