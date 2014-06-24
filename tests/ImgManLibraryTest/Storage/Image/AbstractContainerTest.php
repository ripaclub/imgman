<?php
namespace ImgManLibraryTest\Storage\Image;

use ImgManLibraryTest\ImageManagerTestCase;

class AbstractContainerTest extends ImageManagerTestCase
{
    protected $container;

    public function setUp()
    {
        $this->container = $this->getMockForAbstractClass('ImgManLibrary\Storage\Image\AbstractImageContainer');
    }

    public function testAbstractContainerTestBlob()
    {
        $this->container->setBlob('test');
        $this->assertSame('test', $this->container->getBlob());
    }


    public function testAbstractContainerTestMimeType()
    {
        $this->container->setMimeType('test');
        $this->assertSame('test', $this->container->getMimeType());
    }
} 