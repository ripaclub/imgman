<?php

namespace ImgManLibraryTest\Core\Adapter;

use ImgManLibrary\Core\Adapter\ImagickAdapter;
use ImgManLibrary\Entity\ImageEntity;
use ImgManLibraryTest\Core\Adapter\TestAsset\WrongImage;
use ImgManLibraryTest\ImageManagerTestCase;

class ImagickAdapterTest extends ImageManagerTestCase
{
    /**
     * @var \ImgManLibrary\Core\Adapter\ImagickAdapter
     */
    protected $adapter;

    /**
     * @var \ImgManLibrary\Entity\ImageEntity
     */
    protected $image;

    /**
     * @var \ImgManLibrary\Entity\ImageEntity
     */
    protected $image2;

    public function setUp()
    {
        $this->image = new ImageEntity(__DIR__ . '/../../Entity/img/test.jpg');
        $this->adapter = new ImagickAdapter($this->image);
        $this->image2 = new ImageEntity(__DIR__ . '/../../Entity/img/test2.png');
    }

    public function testImagickAdapterConstructImageHeigh()
    {
        $height = $this->adapter->getHeight();
        $width = $this->adapter->getWidth();
        $this->assertInternalType("int", $height);
        $this->assertInternalType("int", $width);
    }

    /**
     * @expectedException \ImgManLibrary\Core\Adapter\Exception\ImageException
     */
    public function testImagickAdapterLoadImageException()
    {
        $wrongImage = new WrongImage();
        $wrongImage->setBlob('test');
        $this->adapter = new ImagickAdapter($wrongImage);
    }

    public function testImagickAdapterInstance()
    {
        $this->assertInstanceOf('Imagick', $this->adapter->getAdapter());
    }

    public function testImagickAdapterGetBlob()
    {
        $this->assertInstanceOf("\ImgManLibrary\BlobInterface", $this->adapter->getBlob());
    }

    public function testImagickAdapterSetBlob()
    {
        $this->assertInstanceOf('ImgManLibrary\Core\Adapter\ImagickAdapter', $this->adapter->setBlob($this->image2));
    }

    public function testImagickAdapterImageHeight()
    {
        $this->assertInternalType("int", $this->adapter->getHeight());
    }

    public function testImagickAdapterImageWidth()
    {
        $this->assertInternalType("int", $this->adapter->getWidth());
    }

    public function testImagickAdapterImageResize()
    {
        $this->assertTrue($this->adapter->resize(50, 50));
    }

    public function testImagickAdapterImageCrop()
    {
        $this->assertTrue($this->adapter->crop(0, 0, 50, 50));
    }

    public function testImagickAdapterImageRotate()
    {
        $this->assertTrue($this->adapter->rotate(180, 'black'));
    }

    public function testImagickAdapterImageSetFormat()
    {
        $this->assertInstanceOf('ImgManLibrary\Core\Adapter\ImagickAdapter', $this->adapter->setFormat('png'));
    }

    /**
     * @depends testImagickAdapterImageSetFormat
     */
    public function testImagickAdapterImageGetFormat()
    {
        $this->adapter->setFormat('png');
        $this->expectOutputString($this->adapter->getFormat());
        print 'png';
    }

    public function testImagickAdapterGetFormatLoaded()
    {
        $this->adapter->setBlob($this->image);
        $this->expectOutputString($this->adapter->getMimeTypeLoaded());

        print 'image/jpeg';
    }
}