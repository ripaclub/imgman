<?php
namespace ImgManLibraryTest\Storage\Adapter\Mongo;

use ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter;
use ImgManLibraryTest\ImageManagerTestCase;

class MongoAdapterTest extends ImageManagerTestCase
{
    /**
     * @var \ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter
     */
    protected $adapter;

    public function setUp()
    {
       // $this->adapter = new MongoAdapter($this->);
    }

    public function testMongoAdapterConstruct()
    {
        $connMongo = new \MongoDB(new \MongoClient(), 'test');

        $adapter = new MongoAdapter($connMongo, 'test');
    }
} 