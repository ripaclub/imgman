<?php
/**
 * Created by visa
 * Date:  08/02/15 20.01
 * Class: ImageTraitTest.php
 */

namespace ImgManTest\Image;


use ImgMan\Image\ImageTrait;
use ImgManTest\ImageManagerTestCase;

class ImageTraitTest extends ImageManagerTestCase
{
    /**
     * @var ImageTrait
     */
    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgMan\Image\ImageTrait');
    }

    public function testImageTraitGetSetMimeType()
    {
        $this->assertEquals($this->traitObject, $this->traitObject->setMimeType('image'));
        $this->assertEquals('image', $this->traitObject->getMimeType());
    }

    public function testImageTraitGetSetSize()
    {
        $this->assertEquals($this->traitObject, $this->traitObject->setSize(1000));
        $this->assertEquals(1000, $this->traitObject->getSize());
    }
} 