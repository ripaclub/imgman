<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage\Adapter\FileSystem;

use ImgManTest\ImageManagerTestCase;
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
                    'resolver' => 'ImgMan\ResolverDefault'
                ),
            )
        );

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgMan\Storage\Adapter\FileSystem\FileSystemAbstractServiceFactory',
                    ),
                    'invokables' => array(
                        'ImgMan\ResolverDefault' => 'ImgMan\Storage\Adapter\FileSystem\Resolver\ResolverDefault'
                    )
                )
            )
        );

         $this->serviceManager->setService('Config', $config);
    }

    public function testFileSystemAbstractFactoryService()
    {
        $this->assertTrue($this->serviceManager->has('ImgMan\Storage\FileSystem'));
        $this->assertInstanceOf('ImgMan\Storage\StorageInterface', $this->serviceManager->get('ImgMan\Storage\FileSystem'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgMan\Storage\Adapter\FileSystem\FileSystemAbstractServiceFactory',
                    ),
                )
            )
        );

        $this->assertFalse($this->serviceManager->has('ImgMan\Storage\FileSystem'));

        $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                    'abstract_factories' => array(
                        'ImgMan\Storage\Adapter\FileSystem\FileSystemAbstractServiceFactory',
                    ),
                )
            )
        );

        $this->serviceManager->setService('Config', array());
        $this->assertFalse($this->serviceManager->has('ImgMan\Storage\FileSystem'));
   //     $this->assertTrue(false);
    }
}
