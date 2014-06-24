<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 19/06/14
 * Time: 17.51
 */

namespace ImgManLibraryTest\Storage\Adapter\Mongo;

use ImgManLibraryTest\ImageManagerTestCase;
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
                        'ImgManLibrary\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
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
                        'ImgManLibrary\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
                    ),
                )
            )
        );

        $this->assertFalse($this->serviceManager->has('MongoDb'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgManLibrary\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
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