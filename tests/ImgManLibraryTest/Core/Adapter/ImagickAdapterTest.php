<?php

namespace ImgManLibraryTest\Core\Adapter;

use ImgManLibrary\Core\Adapter\ImagickAdapter;
use ImgManLibraryTest\Core\Adapter\TestAsset\Image\Container;
use ImgManLibraryTest\Core\Adapter\TestAsset\Image\WrongImage;
use ImgManLibraryTest\ImageManagerTestCase;

class ImagickAdapterTest extends ImageManagerTestCase
{
    /**
     * @var \ImgManLibrary\Core\Adapter\ImagickAdapter
     */
    protected $adapter;

    /**
     * @var Container
     */
    protected $image;

    /**
     * @var Container
     */
    protected $image2;

    /**
     * @var Container
     */
    protected $image3;

    public function setUp()
    {
        if (!extension_loaded('imagick')) {
            $this->markTestSkipped(
                'The imagick extension is not available.'
            );
        }

        $this->image = new Container(__DIR__ . '/../../Image/img/test.jpg');
        $this->image2 = new Container(__DIR__ . '/../../Image/img/test.png');
        $this->image3 = new Container(__DIR__ . '/../../Image/img/test.gif');

        $this->adapter = new ImagickAdapter($this->image);
    }

    public function testImagickAdapterConstructImageHeightWidth()
    {
        $height = $this->adapter->getHeight();
        $width = $this->adapter->getWidth();
        $this->assertInternalType("int", $height);
        $this->assertInternalType("int", $width);

        $this->adapter->setBlob($this->image2);
        $height = $this->adapter->getHeight();
        $width = $this->adapter->getWidth();
        $this->assertInternalType("int", $height);
        $this->assertInternalType("int", $width);

        $this->adapter->setBlob($this->image3);
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
        $this->assertInstanceOf('ImgManLibrary\Core\Adapter\ImagickAdapter', $this->adapter->setBlob($this->image3));
        $this->assertInstanceOf('ImgManLibrary\Core\Adapter\ImagickAdapter', $this->adapter->setBlob($this->image));
    }

    public function testImagickAdapterGetRation()
    {
        $this->assertGreaterThanOrEqual(0, $this->adapter->getRatio());
        $this->adapter->setBlob($this->image2);
        $this->assertGreaterThanOrEqual(0, $this->adapter->getRatio());
        $this->adapter->setBlob($this->image3);
        $this->assertGreaterThanOrEqual(0, $this->adapter->getRatio());

    }

    public function testImagickAdapterGetMimeTypeJpeg()
    {
        $this->adapter->setBlob($this->image);
        $this->expectOutputString($this->adapter->getMimeType());

        print 'image/jpeg';
    }

    public function testImagickAdapterGetMimeTypePng()
    {
        $this->adapter->setBlob($this->image2);
        $this->expectOutputString($this->adapter->getMimeType());

        print 'image/png';
    }

    public function testImagickAdapterGetMimeTypeGif()
    {
        $this->adapter->setBlob($this->image3);
        $this->expectOutputString($this->adapter->getMimeType());

        print 'image/gif';
    }

    public function testImagickAdapterImageHeight()
    {
        $this->assertInternalType("int", $this->adapter->getHeight());
        $this->adapter->setBlob($this->image2);
        $this->assertInternalType("int", $this->adapter->getHeight());
        $this->adapter->setBlob($this->image3);
        $this->assertInternalType("int", $this->adapter->getHeight());
    }

    public function testImagickAdapterImageWidth()
    {
        $this->assertInternalType("int", $this->adapter->getWidth());
        $this->adapter->setBlob($this->image3);
        $this->assertInternalType("int", $this->adapter->getWidth());
        $this->adapter->setBlob($this->image2);
        $this->assertInternalType("int", $this->adapter->getWidth());
    }

    public function testImagickAdapterImageResize()
    {
        $this->assertTrue($this->adapter->resize(50, 50));
        $this->assertSame(50, $this->adapter->getWidth());
        $this->assertSame(50, $this->adapter->getHeight());

        $this->adapter->setBlob($this->image2);
        $this->assertTrue($this->adapter->resize(80, 80));
        $this->assertSame(80, $this->adapter->getWidth());
        $this->assertSame(80, $this->adapter->getHeight());

        $this->adapter->setBlob($this->image3);
        $this->assertTrue($this->adapter->resize(100, 100));
        $this->assertSame(100, $this->adapter->getWidth());
        $this->assertSame(100, $this->adapter->getHeight());
    }

    public function testImagickAdapterImageCrop()
    {
        $this->assertTrue($this->adapter->crop(0, 0, 50, 50));
        $this->adapter->setBlob($this->image2);
        $this->assertTrue($this->adapter->crop(0, 0, 50, 50));
        $this->adapter->setBlob($this->image3);
        $this->assertTrue($this->adapter->crop(0, 0, 50, 50));
    }

    public function testImagickAdapterImageRotate()
    {
        $this->assertTrue($this->adapter->rotate(180, 'black'));
        $this->adapter->setBlob($this->image2);
        $this->assertTrue($this->adapter->rotate(180, 'black'));
        $this->adapter->setBlob($this->image3);
        $this->assertTrue($this->adapter->rotate(180, 'black'));
    }

    public function testImagickAdapterImageGetFormat()
    {
        $this->assertEquals('JPEG', $this->adapter->getFormat());
        $adapter = new ImagickAdapter();
        $this->assertNull($adapter->getFormat());
    }

    public function testImagickAdapterImageGetClear()
    {
        $this->assertTrue($this->adapter->clear());
    }

    public function testImagickAdapterImageFormat()
    {
        $this->assertTrue($this->adapter->format('png'));
        $this->assertTrue($this->adapter->format('jpeg'));
        $this->assertTrue($this->adapter->format('gif'));
    }

    public function testImagickAdapterImageCompression()
    {
        $this->assertTrue($this->adapter->compression(50, 50));
        $this->adapter->setBlob($this->image2);
        $this->assertTrue($this->adapter->compression(50, 50));
        $this->adapter->setBlob($this->image3);
        $this->assertTrue($this->adapter->compression(50, 50));
    }

    public function testImagickAdapterImageCreate()
    {
        $imgPng = $this->adapter->create(50, 50, 'png');
        $this->assertInstanceOf('ImgManLibrary\Core\Blob\Blob', $imgPng);
        $this->assertNotEmpty($imgPng->getBlob());

        $imgJpeg = $this->adapter->create(50, 50, 'jpeg');
        $this->assertInstanceOf('ImgManLibrary\Core\Blob\Blob', $imgJpeg);
        $this->assertNotEmpty($imgJpeg->getBlob());
    }

    /**
     * @depends testImagickAdapterImageCreate
     */
    public function testImagickAdapterImageComposeOne()
    {
        $imageBackground = $this->adapter->create(50, 50, $this->adapter->getFormat());
        $this->assertTrue($this->adapter->compose($imageBackground, 10, 10));
        $this->assertSame(50, $this->adapter->getWidth());
        $this->assertSame(50, $this->adapter->getHeight());
    }

    /**
     * @depends testImagickAdapterImageCreate
     */
    public function testImagickAdapterImageComposeTwo()
    {
        $adapter = new ImagickAdapter();
        $imageBackground = $this->adapter->create(50, 50, 'JPEG');
        $this->assertTrue($this->adapter->compose($imageBackground, 10, 10, $this->adapter->getBlob()));
        $this->assertSame(50, $this->adapter->getWidth());
        $this->assertSame(50, $this->adapter->getHeight());
    }

    public function testImagickAdapterImageException()
    {
        $this->adapter->setAdapter($this->getMockImagick());

        $this->assertNull( $this->adapter->getMimeType());
        $this->assertEquals(0, $this->adapter->getRatio());
        $this->assertEquals(0, $this->adapter->getHeight());
        $this->assertEquals(0, $this->adapter->getWidth());
        $this->assertFalse($this->adapter->resize(100, 100));
        $this->assertFalse($this->adapter->compression(10, 10));
        $this->assertFalse($this->adapter->crop(10, 10, 150, 150));
        $this->assertFalse($this->adapter->rotate(180));
    }

    /**
     * @expectedException \ImgManLibrary\Core\Adapter\Exception\ImageException
     */
    public function testImagickAdapterImageExceptionSetBlob()
    {
        $this->adapter->setAdapter($this->getMockImagick());

        $this->assertFalse($this->adapter->setBlob($this->image));
    }

    protected function getMockImagick()
    {
        $imagickMock = $this->getMock('Imagick');
        $imagickMock->expects($this->any())
            ->method('identifyimage')
            ->will($this->throwException(new \ImagickException()));

        $imagickMock->expects($this->any())
            ->method('getimageheight')
            ->will($this->throwException(new \ImagickException()));

        $imagickMock->expects($this->any())
            ->method('getimagewidth')
            ->will($this->throwException(new \ImagickException()));

        $imagickMock->expects($this->any())
            ->method('thumbnailImage')
            ->will($this->throwException(new \ImagickException()));

        $imagickMock->expects($this->any())
            ->method('setimagecompressionquality')
            ->will($this->throwException(new \ImagickException()));

        $imagickMock->expects($this->any())
            ->method('setcompressionquality')
            ->will($this->throwException(new \ImagickException()));

        $imagickMock->expects($this->any())
            ->method('cropimage')
            ->will($this->throwException(new \ImagickException()));

        $imagickMock->expects($this->any())
            ->method('rotateimage')
            ->will($this->throwException(new \ImagickException()));

        $imagickMock->expects($this->any())
            ->method('readimageblob')
            ->will($this->returnValue(false));

        return $imagickMock;
    }
}