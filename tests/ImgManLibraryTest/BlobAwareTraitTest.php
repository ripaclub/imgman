<?php
namespace ImgManLibraryTest;


class BlobAwareTraitTest extends ImageManagerTestCase
{
    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgManLibrary\BlobAwareTrait');
    }

    public function testPluginManagerAwareTraitTest()
    {
        $this->traitObject->setBlob('test');
        $this->assertEquals('test', $this->traitObject->getBlob());
    }
} 