<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Image;

use ImgMan\Image\ImageContainer;
use ImgManTest\ImageManagerTestCase;

/**
 * Class ImageContainerTest
 */
class ImageContainerTest extends ImageManagerTestCase
{
    public function testEntityUrlPath()
    {
        $imgUrl = 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQuam7POSn1Tb-RzIYFMBQZ9eFBYWcmpmkGWNQYVK0Nd1zGx5jVXKpqh9mF';
        $entity = new ImageContainer($imgUrl);
        $this->assertNotEmpty($entity->getBlob());
    }


    public function testContainerUrlDisk()
    {
        $entity = new ImageContainer(__DIR__ . '/img/test.jpg');
        $this->assertNotEmpty($entity->getBlob());
    }

    /**
     * @expectedException \ImgMan\Image\Exception\FileNotFound
     */
    public function testContainerUrlWrong()
    {
        error_reporting(E_ERROR);
        new ImageContainer('test.txt');
    }
}
