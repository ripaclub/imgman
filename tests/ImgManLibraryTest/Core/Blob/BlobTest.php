<?php

namespace ImgManLibraryTest\Core\Blob;

use ImgManLibrary\Core\Blob\Blob;
use ImgManLibraryTest\ImageManagerTestCase;

class BlobTest extends ImageManagerTestCase
{
    protected  $blob;

    public function setUp()
    {
        $this->blob = new Blob();
    }

    public function testImagickCoreBlob()
    {
        $this->blob->setBlob('test');
        $this->assertEquals($this->blob->getBlob(), 'test');
    }
} 