<?php
namespace ImgManTest\Storage\Adapter\FileSystem\Image;

use ImgMan\Storage\Adapter\FileSystem\Image\FileSystemImageTrait;
use ImgManTest\ImageManagerTestCase;
/**
 * Class FileSystemImageTraitTest
 *
 *
 * @package ImgManTest\Storage
 */
class FileSystemImageTraitTest extends ImageManagerTestCase
{
    /**
     * @var FileSystemImageTrait
     */
    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgMan\Storage\Adapter\FileSystem\Image\FileSystemImageTrait');
    }

    public function testFileSystemImageTraitGetSetPath()
    {
        $this->traitObject->setPath('test');
        $this->assertEquals('test', $this->traitObject->getPath());
    }

}
