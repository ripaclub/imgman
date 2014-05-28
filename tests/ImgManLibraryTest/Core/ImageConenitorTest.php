<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 12.52
 */

namespace ImgManLibraryTest\Core;

use ImgManLibrary\Core\ImageContenitor;
use ImgManLibrary\Entity\ImageEntity;
use ImgManLibraryTest\ImageManagerTestCase;

class ImageConenitorTest extends ImageManagerTestCase
{

    public function testImageContenitorSetBlob()
    {
        $image = new ImageEntity(__DIR__ . '/../Entity/img/test.jpg');
        $imageContenitor = new ImageContenitor();
        $this->assertInstanceOf('\ImgManLibrary\Core\ImageContenitor', $imageContenitor->setBlob($image->getBlob()));
    }

    public function testImageContenitorGetBlob()
    {
        $image = new ImageEntity(__DIR__ . '/../Entity/img/test.jpg');
        $imageContenitor = new ImageContenitor();
        $imageContenitor->setBlob($image->getBlob());
        $this->assertNotEmpty($imageContenitor->getBlob());
    }
} 