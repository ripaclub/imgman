<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 21/05/14
 * Time: 17.24
 */

namespace ImgManLibraryTest\Entity;

use ImgManLibrary\Entity\ImageEntity;
use ImgManLibraryTest\ImageManagerTestCase;

class EntityTest extends ImageManagerTestCase
{

    public function testEntityUrlPath()
    {
        $entity = new ImageEntity('https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQuam7POSn1Tb-RzIYFMBQZ9eFBYWcmpmkGWNQYVK0Nd1zGx5jVXKpqh9mF');
        $this->assertNotEmpty($entity->getBlob());
    }


    public function testEntityUrlDisk()
    {
        $entity = new ImageEntity(__DIR__ . '/img/test.jpg');
        $this->assertNotEmpty($entity->getBlob());
    }

    /**
     * @expectedException \ImgManLibrary\Entity\Exception\FileNotFound
     */
    public function testEntityUrlWrong()
    {
        $entity = new ImageEntity('test.txt');
    }
} 