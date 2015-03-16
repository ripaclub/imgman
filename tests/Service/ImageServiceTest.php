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
use ImgMan\Service\ImageService;
use ImgMan\Storage\Adapter\Mongo\MongoAdapter;
use ImgManTest\Core\Adapter\TestAsset\Image\RightImage;
use ImgManTest\ImageManagerTestCase;

/**
 * Class ServiceTest
 */
class ImageServiceTest extends ImageManagerTestCase
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
        $service = new ImageService($storage, $pluginManager, $adapter);
        $this->assertInstanceOf('ImgMan\Service\ImageServiceInterface', $service);
    }

    /**
     * @expectedException \ImgMan\Service\Exception\InvalidArgumentException
     */
    public function testServiceCheckIdentifierFalse()
    {
        error_reporting(E_ERROR);

        $image = new RightImage(__DIR__ . '/../Image/img/test.jpg');

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
        $service = new ImageService($storage, $pluginManager, $adapter);
        $service->setRegExIdentifier('test');

        $service->save('test/test', $image);
    }

    /**
     * @expectedException \ImgMan\Service\Exception\InvalidArgumentException
     */
    public function testServiceCheckIdentifierException2()
    {
        $image = new RightImage(__DIR__ . '/../Image/img/test.jpg');

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
        $service = new ImageService($storage, $pluginManager, $adapter);
        $service->save('invalidIdentifier?invalid', $image);
    }

    public function testServiceRegExIdentifierGetSet()
    {
        $service = new ImageService();
        $regEx = '/(\d+)/';
        $service->setRegExIdentifier($regEx);
        $this->assertSame($regEx, $service->getRegExIdentifier());
    }

    /**
     * @expectedException \ImgMan\Service\Exception\InvalidArgumentException
     */
    public function testServiceRegExIdentifierInvalidIdentifierSyntax()
    {
        $service = new ImageService();
        $regEx = 'test';
        $service->setRegExIdentifier($regEx);
    }

    /**
     * @expectedException \ImgMan\Service\Exception\InvalidArgumentException
     */
    public function testServiceRegExIdentifierInvalidIdentifierRenditionSeparator()
    {
        $service = new ImageService();
        $regEx = '/(\#)/';
        $service->setRegExIdentifier($regEx);
    }

    /**
     * @expectedException \ImgMan\Service\Exception\InvalidRenditionException
     */
    public function testServiceSetRenditionException()
    {
        $service = new ImageService();
        $service->setRenditions(['original' => ['test']]);
    }

    /**
     * @expectedException \ImgMan\Service\Exception\RuntimeException
     */
    public function testServiceGetExceptionStorage()
    {
        $service = new ImageService();
        $service->getStorage();
    }

    public function testServiceSave()
    {
        $image = new RightImage(__DIR__ . '/../Image/img/test.jpg');

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
        $service = new ImageService($storage, $pluginManager, $adapter);
        $this->assertTrue($service->save('test/test/', $image));
    }

    /**
     * @expectedException \ImgMan\Service\Exception\IdAlreadyExistsException
     */
    public function testServiceSaveException()
    {
        $image = new RightImage(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');

        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new ImageService($storage, $pluginManager, $adapter);
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
        $service = new ImageService($storage, $pluginManager, $adapter);
        $this->assertTrue($service->delete('test/test/'));

    }

    public function testServiceUpdate()
    {
        $image = new RightImage(__DIR__ . '/../Image/img/test.jpg');

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
        $service = new ImageService($storage, $pluginManager, $adapter);
        $this->assertTrue($service->update('test/test/', $image));
    }

    /**
     * @expectedException \ImgMan\Service\Exception\IdNotExistsException
     */
    public function testServiceUpdateException()
    {
        $image = new RightImage(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');
        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new ImageService($storage, $pluginManager, $adapter);
        $service->update('test/test/', $image);
    }

    public function testServiceGet()
    {
        $image = $this->getMockForAbstractClass('ImgMan\Image\Image');

        $storage =  $this->getMock('ImgMan\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('getImage')
            ->will($this->returnValue($image));

        $adapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('getMimeType')
            ->will($this->returnValue('image/png'));

        $pluginManager =  $this->getMock('ImgMan\Operation\HelperPluginManager');
        /** @var $storage MongoAdapter */
        /** @var $pluginManager HelperPluginManager */
        /** @var $adapter ImagickAdapter */
        $service = new ImageService($storage, $pluginManager, $adapter);
        $this->assertSame($image, $service->get('test/test/', 'thumb'));
    }

    public function testServiceApplyRendition()
    {
        $image = new RightImage(__DIR__ . '/../Image/img/test.jpg');

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
        $service = new ImageService($storage, $pluginManager, $adapter);
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
        $image = new RightImage(__DIR__ . '/../Image/img/test.jpg');

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
        $service = new ImageService($storage, $pluginManager, $adapter);
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

        $service = new ImageService($storage, $pluginManager, $adapter);
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
