<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 25/06/14
 * Time: 11.01
 */

namespace ImgManLibraryTest\Storage\Adapter\FileSystem;

use ImgManLibraryTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager;

class FileSystemAbstractFactoryServiceTest extends ImageManagerTestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $config = array(
            'imgManFileSystemStorage' => array(
                'ImgMan\Storage\FileSystem' => array(
                    'path' => __DIR__ . '/test',
                    'resolver' => 'ImgManLibrary\ResolverDefault'
                ),
            )
        );

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgManLibrary\Storage\Adapter\FileSystem\FileSystemAbstractServiceFactory',
                    ),
                    'invokables' => array(
                        'ImgManLibrary\ResolverDefault' => 'ImgManLibrary\Storage\Adapter\FileSystem\Resolver\ResolverDefault'
                    )
                )
            )
        );

        $this->serviceManager->setService('Config', $config);
    }

    public function testFileSystemAbstractFactoryService()
    {
        $this->assertTrue($this->serviceManager->has('ImgMan\Storage\FileSystem'));
        $this->assertInstanceOf('ImgManLibrary\Storage\StorageInterface', $this->serviceManager->get('ImgMan\Storage\FileSystem'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgManLibrary\Storage\Adapter\FileSystem\FileSystemAbstractServiceFactory',
                    ),
                )
            )
        );

        $this->assertFalse($this->serviceManager->has('ImgMan\Storage\FileSystem'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgManLibrary\Storage\Adapter\FileSystem\FileSystemAbstractServiceFactory',
                    ),
                )
            )
        );

        $this->serviceManager->setService('Config', array());
        $this->assertFalse($this->serviceManager->has('ImgMan\Storage\FileSystem'));
    }
} 