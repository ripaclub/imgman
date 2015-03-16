<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Image;

use ImgMan\Image\Image;
use ImgManTest\ImageManagerTestCase;

/**
 * Class ImageContainerTest
 */
class ImageTest extends ImageManagerTestCase
{
    public function testImageEmptyParamsToConstruct()
    {
        $image = new Image();
        $this->assertInstanceOf('ImgMan\Image\Image', $image);
    }

    public function testImageUrlPath()
    {
        $imgUrl = 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQuam7POSn1Tb-RzIYFMBQZ9eFBYWcmpmkGWNQYVK0Nd1zGx5jVXKpqh9mF';
        $entity = new Image($imgUrl);
        $this->assertNotEmpty($entity->getBlob());
    }

    public function testImageFileSystemPath()
    {
        $image = new Image(__DIR__ . '/img/test.jpg');
        $this->assertNotEmpty($image->getBlob());
    }

    /**
     * @expectedException \ImgMan\Image\Exception\FileNotFound
     */
    public function testContainerUrlWrong()
    {
        error_reporting(E_ERROR);
        new Image('test.txt');
    }
}
