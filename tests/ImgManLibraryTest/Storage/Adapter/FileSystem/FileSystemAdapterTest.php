<?php
namespace ImgManLibraryTest\Storage\Adapter\FileSystem;

use ImgManLibrary\Storage\Adapter\FileSystem\FileSystemAdapter;
use ImgManLibraryTest\ImageManagerTestCase;
use ImgManLibraryTest\Core\Adapter\TestAsset\Image\Container;
class FileSystemAdapterTest extends ImageManagerTestCase
{

    public $fileSystem;

    public $path;

    public $image;

    public $id;

    public function setUp()
    {
        $this->path = __DIR__ . '/test';

        $this->id = 'test/test';

        $this->fileSystem = new FileSystemAdapter();

        $resolver = $this->getMock('ImgManLibrary\Storage\Adapter\FileSystem\Resolver\ResolverDefault');
        $resolver->expects($this->any())
            ->method('resolvePathDir')
            ->will($this->returnValue(__DIR__ . '/test'));
        $resolver->expects($this->any())
            ->method('resolveName')
            ->will($this->returnValue(md5('test')));

        $this->fileSystem->setPath($this->path);
        $this->fileSystem->setResolver($resolver);
    }

    public function testGetSet()
    {
        $fileSystem = new FileSystemAdapter();
        $path = __DIR__;
        $resolver = $this->getMock('ImgManLibrary\Storage\Adapter\FileSystem\Resolver\ResolverDefault');

        /* @var $this->fileSystem ImgManLibrary\Storage\Adapter\FileSystem\FileSystemAdapter */
        $fileSystem->setPath($path);
        $this->assertSame($path,  $fileSystem->getPath($path));

        $fileSystem->setResolver($resolver);
        $this->assertSame($resolver,  $fileSystem->getResolver());
    }

    public function testFileSystemAdapterGet()
    {
        $this->assertFalse($this->fileSystem->getImage('test/test'));
    }

    /**
     * @depends testFileSystemAdapterGet
     */
    public function testFileSystemAdapterHas()
    {
        $this->assertFalse($this->fileSystem->hasImage('test/test'));
    }

    /**
     * @depends testFileSystemAdapterGet
     */
    public function testFileSystemAdapterSave()
    {
        $this->image = new Container(__DIR__ . '/../../../Image/img/test.jpg');
        $this->assertTrue($this->fileSystem->saveImage('test/test', $this->image));
        $this->assertFalse($this->fileSystem->hasImage('test/test'));
        $this->assertTrue($this->fileSystem->deleteImage('test/test'));
    }
} 