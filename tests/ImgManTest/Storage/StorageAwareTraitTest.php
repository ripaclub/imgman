<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage;

use ImgManTest\ImageManagerTestCase;

class StorageAwareTraitTest extends ImageManagerTestCase
{

    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgMan\Storage\StorageAwareTrait');
    }

    public function testStorageAwareTrait()
    {
        $this->traitObject->setStorage(
            $this->getMockBuilder('ImgMan\Storage\Adapter\Mongo\MongoAdapter')
            ->disableOriginalConstructor()
            ->getMock()
        );
        $this->assertInstanceOf('ImgMan\Storage\StorageInterface',  $this->traitObject->getStorage());
    }
}
