<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage;

use ImgMan\Storage\Adapter\Mongo\MongoAdapter;
use ImgMan\Storage\StorageAwareTrait;
use ImgManTest\ImageManagerTestCase;

/**
 * Class StorageAwareTraitTest
 */
class StorageAwareTraitTest extends ImageManagerTestCase
{
    /**
     * @var StorageAwareTrait
     */
    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgMan\Storage\StorageAwareTrait');
    }

    public function testStorageAwareTrait()
    {
        /** @var $adapter MongoAdapter */
        $adapter = $this->getMockBuilder('ImgMan\Storage\Adapter\Mongo\MongoAdapter')
            ->disableOriginalConstructor()
            ->getMock();
        $this->traitObject->setStorage($adapter);
        $this->assertInstanceOf('ImgMan\Storage\StorageInterface', $this->traitObject->getStorage());
    }
}
