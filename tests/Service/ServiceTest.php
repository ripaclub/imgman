<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Service;

use ImgMan\Core\Adapter\ImagickAdapter;
use ImgMan\Operation\HelperPluginManager;
use ImgMan\Service\Service;
use ImgMan\Storage\Adapter\Mongo\MongoAdapter;
use ImgManTest\ImageManagerTestCase;
use ImgManTest\Service\TestAsset\Container;

/**
 * Class ServiceTest
 */
class ServiceTest extends ImageManagerTestCase
{

    public function setUp()
    {
        if (!extension_loaded('imagick')) {
            $this->markTestSkipped(
                'The imagick extension is not available.'
            );
        }
    }


    public function testServiceConstruct()
    {
        /** @var $adapter ImagickAdapter */
        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        /** @var $storage MongoAdapter */
        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        /** @var $pluginManager HelperPluginManager */
        $pluginManager = $this->getMock('ImgMan\Operation\HelperPluginManager');
        $service = new Service($storage, $pluginManager, $adapter);
        $this->assertInstanceOf('ImgMan\Service\Service', $service);
    }

    /**
     * @expectedException \ImgMan\Service\Exception\InvalidArgumentException
     */
    public function testServiceCheckIdentifierFalse()
    {
        error_reporting(E_ERROR);

        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');

        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $service->setRegExIdentifier('test');

        $service->save('test/test', $image);
    }

    /**
     * @expectedException \ImgMan\Service\Exception\InvalidArgumentException
     */
    public function testServiceCheckIdentifierException2()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');

        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $service->save('invalidIdentifier?invalid', $image);
    }

    public function testServiceGetSet()
    {
        $service = new Service();
        $service->setRenditions(
            [
                'thumb' => [
                    'resize' => [
                        'width'  => 200,
                        'height' => 200
                    ],
                ],
            ]
        );
        $this->assertArrayHasKey('thumb', $service->getRenditions());
        $service->setRegExIdentifier('exprReg');
        $this->assertSame('exprReg', $service->getRegExIdentifier());
    }

    /**
     * @expectedException \ImgMan\Service\Exception\InvalidRenditionException
     */
    public function testServiceSetRenditionException()
    {
        $service = new Service();
        $service->setRenditions(['original' => ['test']]);
    }

    public function testServiceSave()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');

        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $this->assertTrue($service->save('test/test/', $image));
    }

    /**
     * @expectedException \ImgMan\Service\Exception\IdAlreadyExistsException
     */
    public function testServiceSaveException()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');

        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $service->save('test/test/', $image);
    }

    public function testServiceDelete()
    {
        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('deleteImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');

        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $this->assertTrue($service->delete('test/test/'));

    }

    public function testServiceUpdate()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(true));
        $storage->expects($this->any())
            ->method('updateImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));

        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');

        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $this->assertTrue($service->update('test/test/', $image));
    }

    /**
     * @expectedException \ImgMan\Service\Exception\IdNotExistsException
     */
    public function testServiceUpdateException()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');
        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $service->update('test/test/', $image);
    }

    public function testServiceGet()
    {
        $containerStorage = $this->getMockForAbstractClass('ImgMan\Storage\Image\AbstractStorageContainer');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('getImage')
            ->will($this->returnValue($containerStorage));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('getMimeType')
            ->will($this->returnValue('image/png'));

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');
        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $this->assertSame($containerStorage, $service->get('test/test/', 'thumb'));
    }

    public function testServiceApplyRendition()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));
        /* @var $pluginManager  \Zend\ServiceManager\AbstractPluginManager */
        $helper = $this->getMock('ImgMan\Operation\Helper\Resize');
        $helper->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(true));

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');
        $pluginManager->expects($this->any())
            ->method('get')
            ->will($this->returnValue($helper));

        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $service->setRenditions(
            [
                'thumb' => [
                    'resize' => [
                        'width'  => 200,
                        'height' => 200
                    ]
                ]
            ]
        );

        $this->assertTrue($service->save('test/test/', $image, 'thumb'));
    }

    public function testServiceGrab()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));
        /* @var $pluginManager  \Zend\ServiceManager\AbstractPluginManager */
        $helper = $this->getMock('ImgMan\Operation\Helper\Resize');
        $helper->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(true));

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');
        $pluginManager->expects($this->any())
            ->method('get')
            ->will($this->returnValue($helper));
        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new Service($storage, $pluginManager, $adapter);
        $service->setRenditions(
            [
                'thumb' => [
                    'resize' => [
                        'height' => 200,
                        'width'  => 300
                    ]
                ],
                'thumbMaxi' => [
                    'resize' => [
                        'height' => 200,
                        'width'  => 300
                    ]
                ],
            ]
        );
        $this->assertSame('test/test/', $service->grab($image, 'test/test/'));

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(true));
        $storage->expects($this->any())
            ->method('updateImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));

        /* @var $pluginManager  \Zend\ServiceManager\AbstractPluginManager */
        $helper = $this->getMock('ImgMan\Operation\Helper\Resize');
        $helper->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(true));

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');
        $pluginManager->expects($this->any())
            ->method('get')
            ->will($this->returnValue($helper));

        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */

        $service = new Service($storage, $pluginManager, $adapter);
        $service->setRenditions(
            [
                'thumb' => [
                    'resize' => [
                        'height' => 200,
                        'width'  => 300
                    ]
                ],
                'thumbMaxi' => [
                    'resize' => [
                        'height' => 200,
                        'width'  => 300
                    ]
                ],
            ]
        );
        $this->assertSame('test/test/', $service->grab($image, 'test/test/'));

    }
}
