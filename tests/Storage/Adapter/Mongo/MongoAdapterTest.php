<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage\Adapter\Mongo;

use ImgMan\Storage\Adapter\Mongo\MongoAdapter;
use ImgManTest\Core\Adapter\TestAsset\Image\RightImage;
use ImgManTest\ImageManagerTestCase;

/**
 * Class MongoAdapterTest
 */
class MongoAdapterTest extends ImageManagerTestCase
{
    /**
     * @var MongoAdapter
     */
    protected $adapter;

    /**
     * @var RightImage
     */
    protected $image;

    public function setUp()
    {
        $this->image = new RightImage(__DIR__ . '/../../../Image/img/test.jpg');

        $mongoCollection = $this->getMockBuilder('MongoCollection')
            ->disableOriginalConstructor()
            ->getMock();
        $mongoCollection->expects($this->any())
            ->method('save')
            ->will($this->returnValue(true));
        $mongoCollection->expects($this->any())
            ->method('remove')
            ->will($this->returnValue(true));
        $mongoCollection->expects($this->any())
            ->method('update')
            ->will($this->returnValue(true));
        $mongoCollection->expects($this->any())
            ->method('findOne')
            ->will($this->returnValue(
                [
                    'id' => 'fdsfdsfsdf',
                    'blob' => new \MongoBinData($this->image->getBlob(), \MongoBinData::CUSTOM)
                ]
            ));

        $this->adapter = new MongoAdapter();
        /** @var $mongoCollection \MongoCollection */
        $this->adapter->setMongoCollection($mongoCollection);
    }

    public function testMongoAdapterSetGetMongoCollection()
    {
        $mongoCollection = $this->getMockBuilder('MongoCollection')
            ->disableOriginalConstructor()
            ->getMock();

        $adapter = new MongoAdapter();
        /** @var $mongoCollection \MongoCollection */
        $adapter->setMongoCollection($mongoCollection);
        $this->assertSame($mongoCollection, $adapter->getMongoCollection());
    }

    public function testMongoAdapterSave()
    {
        $this->assertTrue($this->adapter->saveImage('id', $this->image));
    }

    public function testMongoAdapterDelete()
    {
        $this->assertTrue($this->adapter->deleteImage('id'));
    }

    public function testMongoAdapterGet()
    {
        $this->assertInstanceOf('ImgMan\Image\Image', $this->adapter->getImage('id'));

        $mongoCollection = $this->getMockBuilder('MongoCollection')
            ->disableOriginalConstructor()
            ->getMock();

        $mongoCollection->expects($this->any())
            ->method('findOne')
            ->will($this->returnValue(false));

        /** @var $mongoCollection \MongoCollection */
        $this->adapter->setMongoCollection($mongoCollection);
        $this->assertNull($this->adapter->getImage('id'));
    }

    public function testMongoAdapterHas()
    {
        $this->assertTrue($this->adapter->hasImage('id'));

        $mongoCollection = $this->getMockBuilder('MongoCollection')
            ->disableOriginalConstructor()
            ->getMock();

        $mongoCollection->expects($this->any())
            ->method('findOne')
            ->will($this->returnValue(false));

        /** @var $mongoCollection \MongoCollection */
        $this->adapter->setMongoCollection($mongoCollection);
        $this->assertFalse($this->adapter->hasImage('id'));
    }

    public function testMongoAdapterUpdate()
    {
        $this->assertTrue($this->adapter->updateImage('id', $this->image));
    }
}
