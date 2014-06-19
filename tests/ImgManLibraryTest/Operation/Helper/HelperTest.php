<?php
namespace ImgManLibraryTest\Operation\Helper;

use ImgManLibrary\Operation\Helper\Compression;
use ImgManLibrary\Operation\Helper\Crop;
use ImgManLibrary\Operation\Helper\FitIn;
use ImgManLibrary\Operation\Helper\FitOut;
use ImgManLibrary\Operation\Helper\Format;
use ImgManLibrary\Operation\Helper\Resize;
use ImgManLibrary\Operation\Helper\Rotate;
use ImgManLibrary\Operation\Helper\ScaleToHeight;
use ImgManLibrary\Operation\Helper\ScaleToWidth;
use ImgManLibraryTest\ImageManagerTestCase;

class HelperTest extends ImageManagerTestCase
{

    public function setUp()
    {

    }


    public function testHelperCompression()
    {
        $mockAdapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('compression')
            ->will($this->returnValue(true));

        $helper = new Compression();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('compression' => 10, 'compressionQuality' => 50)));
    }

    public function testHelperResize()
    {
        $mockAdapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('resize')
            ->will($this->returnValue(true));

        $helper = new Resize();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('width' => 10, 'height' => 50)));
    }

    public function testHelperCrop()
    {
        $mockAdapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('crop')
            ->will($this->returnValue(true));

        $helper = new Crop();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('x' => 10, 'y' => 10, 'width' => 10, 'height' => 50)));
    }

    public function testHelperFitIn()
    {
        $mockAdapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('resize')
            ->will($this->returnValue(true));

        $mockAdapter->expects($this->any())
            ->method('getRatio')
            ->will($this->returnValue(5));

        $mockAdapter->expects($this->any())
            ->method('getHeight')->
            will($this->returnValue(30));

        $mockAdapter->expects($this->any())
            ->method('getWidth')
            ->will($this->returnValue(30));

        $helper = new FitIn();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('width' => 50, 'height' => 50)));
        $this->assertTrue($helper->execute(array('width' => 10, 'height' => 10)));
        $this->assertTrue($helper->execute(array('width' => 10, 'height' => 20)));
        $this->assertTrue($helper->execute(array('width' => 35, 'height' => 45, 'allowUpsample' => true)));
        $this->assertTrue($helper->execute(array('width' => 50, 'height' => 50, 'allowUpsample' => true)));
        $this->assertTrue($helper->execute(array('width' => 50, 'height' => 50, 'backgroundColor' => 'black')));
    }

    public function testHelperFitOut()
    {
        $mockAdapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('resize')
            ->will($this->returnValue(true));

        $mockAdapter->expects($this->any())
            ->method('getRatio')
            ->will($this->returnValue(5));

        $mockAdapter->expects($this->any())
            ->method('getHeight')->
            will($this->returnValue(30));

        $mockAdapter->expects($this->any())
            ->method('getWidth')
            ->will($this->returnValue(30));

        $helper = new FitOut();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('width' => 50, 'height' => 50)));
        $this->assertTrue($helper->execute(array('width' => 100, 'height' => 50)));
    }

    public function testHelperFormat()
    {
        $mockAdapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('format')
            ->will($this->returnValue(true));

        $helper = new Format();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('format' => 'png')));
    }

    public function testHelperRotate()
    {
        $mockAdapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('rotate')
            ->will($this->returnValue(true));

        $helper = new Rotate();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('degrees' => 30, 'background' => 'red')));
    }

    public function testHelperScaleToHeight()
    {
        $mockAdapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('resize')
            ->will($this->returnValue(true));

        $mockAdapter->expects($this->any())
            ->method('getHeight')->
            will($this->returnValue(30));

        $mockAdapter->expects($this->any())
            ->method('getWidth')
            ->will($this->returnValue(30));

        $helper = new ScaleToHeight();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('height' => 100)));
        $this->assertFalse($helper->execute(array('height' => 30)));
    }

    public function testHelperScaleToWidth()
    {
        $mockAdapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('resize')
            ->will($this->returnValue(true));

        $mockAdapter->expects($this->any())
            ->method('getHeight')->
            will($this->returnValue(30));

        $mockAdapter->expects($this->any())
            ->method('getWidth')
            ->will($this->returnValue(30));

        $helper = new ScaleToWidth();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('width' => 100)));
        $this->assertFalse($helper->execute(array('width' => 30)));
    }


    public function testHelperAbstract()
    {
        $traitObject = $this->getObjectForTrait('ImgManLibrary\Operation\Helper\Operation\AbstractOptionTrait');



    }
} 