<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 19/06/14
 * Time: 11.30
 */

namespace ImgManLibraryTest\Storage;

use ImgManLibraryTest\ImageManagerTestCase;

class StorageAwareTraitTest extends ImageManagerTestCase
{

    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgManLibrary\Storage\StorageAwareTrait');
    }

    public function testStorageAwareTrait()
    {
        $this->traitObject->setStorage(
            $this->getMockBuilder('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter')
            ->disableOriginalConstructor()
            ->getMock()
        );
        $this->assertInstanceOf('ImgManLibrary\Storage\StorageInterface',  $this->traitObject->getStorage());
    }
} 