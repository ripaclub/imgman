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

class MongoDbAbstractServiceFactoryTest extends ImageManagerTestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $config = array(
            'imgManMongodb' => array(
                'MongoDb' => array(
                    'database' => 'testImgMan'
                ),
                'MongoDbOption' => array(
                    'database' => 'testImgMan',
                    'username' => 'xyz',
                    'password' => 'xyz',
                    'options' => array(
                        'connect' => true
                    )
                ),
            )
        );

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
                    ),
                )
            )
        );

        $this->serviceManager->setService('Config', $config);
    }

    public function testMongoDbAbstractServiceFactory()
    {
        $this->assertTrue($this->serviceManager->has('MongoDb'));
        $this->assertInstanceOf('MongoDb', $this->serviceManager->get('MongoDb'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
                    ),
                )
            )
        );

        $this->assertFalse($this->serviceManager->has('MongoDb'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
                    ),
                )
            )
        );

        $this->serviceManager->setService('Config', array());
        $this->assertFalse($this->serviceManager->has('MongoDb'));
    }

    /**
     * @expectedException \Zend\ServiceManager\Exception\ServiceNotCreatedException
     */
    public function testMongoDbAbstractServiceFactoryUserPwd()
    {
        $this->assertInstanceOf('MongoDb', $this->serviceManager->get('MongoDbOption'));
    }
} 