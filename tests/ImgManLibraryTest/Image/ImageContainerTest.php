<?php
namespace ImgManLibraryTest\Image;

use ImgManLibrary\Image\ImageContainer;
use ImgManLibraryTest\ImageManagerTestCase;

class ImageContainerTest extends ImageManagerTestCase
{

    public function testEntityUrlPath()
    {
        $entity = new ImageContainer('https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQuam7POSn1Tb-RzIYFMBQZ9eFBYWcmpmkGWNQYVK0Nd1zGx5jVXKpqh9mF');
        $this->assertNotEmpty($entity->getBlob());
    }


    public function testContainerUrlDisk()
    {
        $entity = new ImageContainer(__DIR__ . '/img/test.jpg');
        $this->assertNotEmpty($entity->getBlob());
    }

    /**
     * @expectedException \ImgManLibrary\Image\Exception\FileNotFound
     */
    public function testContainerUrlWrong()
    {
        $entity = new ImageContainer('test.txt');
    }
} 