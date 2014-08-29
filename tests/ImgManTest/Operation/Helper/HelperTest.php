<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Operation\Helper;

use ImgMan\Core\Blob\Blob;
use ImgMan\Operation\Helper\Compression;
use ImgMan\Operation\Helper\Crop;
use ImgMan\Operation\Helper\FitIn;
use ImgMan\Operation\Helper\FitOut;
use ImgMan\Operation\Helper\Format;
use ImgMan\Operation\Helper\Resize;
use ImgMan\Operation\Helper\Rotate;
use ImgMan\Operation\Helper\ScaleToHeight;
use ImgMan\Operation\Helper\ScaleToWidth;
use ImgManTest\ImageManagerTestCase;
use ImgManTest\Operation\Helper\Options\TestAssets\GenericOptions;
use ImgManTest\Operation\Helper\Options\TestAssets\GenericOptionsNoStrinct;
use ImgManTest\Service\TestAsset\Container;
use Zend\Stdlib\ArrayObject;

class HelperTest extends ImageManagerTestCase
{

    public function setUp()
    {

    }

    public function testHelperCompression()
    {
        $mockAdapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('compression')
            ->will($this->returnValue(true));

        $helper = new Compression();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('compression' => 10, 'compressionQuality' => 50)));
    }

    public function testHelperResize()
    {
        $mockAdapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('resize')
            ->will($this->returnValue(true));

        $helper = new Resize();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('width' => 10, 'height' => 50)));
    }

    public function testHelperCrop()
    {
        $mockAdapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('crop')
            ->will($this->returnValue(true));

        $helper = new Crop();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('cordX' => 10, 'cordY' => 10, 'width' => 10, 'height' => 50)));
    }

    public function testHelperFitIn()
    {
        $mockAdapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter', ['compose', 'create', 'getHeight', 'getWidth', 'getRatio']);

        $image = new Container(__DIR__ . '/../../Image/img/test.jpg');
        $mockBlob = new Blob();
        $mockBlob->setBlob($image->getBlob());

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

        $mockAdapter->expects($this->any())
            ->method('compose')
            ->will($this->returnValue(true));

        $mockAdapter->expects($this->any())
            ->method('create')
            ->will($this->returnValue($mockBlob));

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
        $mockAdapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

        $image = new Container(__DIR__ . '/../../Image/img/test.jpg');
        $mockBlob = new Blob();
        $mockBlob->setBlob($image->getBlob());

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

        $mockAdapter->expects($this->any())
            ->method('compose')
            ->will($this->returnValue(true));

        $mockAdapter->expects($this->any())
            ->method('create')
            ->will($this->returnValue($mockBlob));

        $helper = new FitOut();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('width' => 50, 'height' => 50)));
        $this->assertTrue($helper->execute(array('width' => 100, 'height' => 50)));
    }

    public function testHelperFormat()
    {
        $mockAdapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('format')
            ->will($this->returnValue(true));

        $helper = new Format();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('format' => 'png')));
    }

    public function testHelperRotate()
    {
        $mockAdapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

        $mockAdapter->expects($this->any())
            ->method('rotate')
            ->will($this->returnValue(true));

        $helper = new Rotate();
        $helper->setAdapter($mockAdapter);
        $this->assertTrue($helper->execute(array('degrees' => 30, 'background' => 'red')));
    }

    public function testHelperScaleToHeight()
    {
        $mockAdapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

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
        $mockAdapter = $this->getMock('ImgMan\Core\Adapter\ImagickAdapter');

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

    public function testHelperAbstractWithArray()
    {
        $config = array('test_field' => 1);
        $classOption = new GenericOptions($config);

        $this->assertEquals(1, $classOption->test_field);
    }

    public function testHelperAbstractWithTraversable()
    {
        $config = new ArrayObject(array('test_field' => 1));
        $classOption = new GenericOptions($config);

        $this->assertEquals(1, $classOption->test_field);
    }

    public function testHelperAbstractWithSelf()
    {
        $options = new GenericOptions(new GenericOptions(array('test_field' => 1)));

        $this->assertEquals(1, $options->test_field);
    }

    public function testHelperAbstractInvalidFieldThrowsException()
    {
        $this->setExpectedException('BadMethodCallException');
        $options = new GenericOptions(array('foo' => 'bar'));
    }

    public function testHelperAbstractUnsetting()
    {
        $options = new GenericOptions(array('test_field' => 1));

        $this->assertEquals(true, isset($options->test_field));
        unset($options->testField);
        $this->assertEquals(false, isset($options->test_field));
    }

    public function testHelperAbstractGetBadMethodCallException()
    {
        $this->setExpectedException('BadMethodCallException');
        $options = new GenericOptions();
        $options->getTest;
    }

    public function testHelperAbstractUnsetInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $options = new GenericOptions();
        unset($options->test);
    }

    public function testHelperAbstractSetFromArrayInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $options = new GenericOptions('test');
    }

    public function test()
    {
        $options = new GenericOptions();

        $this->assertTrue($options->getStrictMode());

        $options->setStrictMode(false);

        $options->test = 'pippo';
    }
}
