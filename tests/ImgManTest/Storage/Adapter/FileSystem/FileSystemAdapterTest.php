<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage\Adapter\FileSystem;

use ImgMan\Storage\Adapter\FileSystem\FileSystemAdapter;
use ImgManTest\ImageManagerTestCase;
use ImgManTest\Core\Adapter\TestAsset\Image\Container;
use SebastianBergmann\Exporter\Exception;

/**
 * Class FileSystemAdapterTest
 */
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

        $resolver = $this->getMock('ImgMan\Storage\Adapter\FileSystem\Resolver\ResolverDefault');
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
        $resolver = $this->getMock('ImgMan\Storage\Adapter\FileSystem\Resolver\ResolverDefault');

        /* @var $this->fileSystem ImgMan\Storage\Adapter\FileSystem\FileSystemAdapter */
        $fileSystem->setPath($path);
        $this->assertSame($path,  $fileSystem->getPath($path));

        $fileSystem->setResolver($resolver);
        $this->assertSame($resolver,  $fileSystem->getResolver());
    }


    public function testFileSystemAdapterHas()
    {
        $this->assertFalse($this->fileSystem->hasImage('test/test'));
    }

    /**
     * @depends testFileSystemAdapterHas
     */
    public function testFileSystemAdapterGet()
    {
        $this->assertFalse($this->fileSystem->getImage('test/test'));
    }

    /**
     * @depends testFileSystemAdapterHas
     */
    public function testFileSystemAdapterSave()
    {
        $this->image = new Container(__DIR__ . '/../../../Image/img/test.jpg');
        $this->assertTrue($this->fileSystem->saveImage('test/test', $this->image));
    }

    /**
     * @depends testFileSystemAdapterSave
     */
    public function testFileSystemAdapterUpdate()
    {
        $this->image = new Container(__DIR__ . '/../../../Image/img/test.jpg');
        $this->assertTrue($this->fileSystem->updateImage('test/test', $this->image));
    }

    /**
     * @depends testFileSystemAdapterSave
     */
    public function testFileSystemAdapterDelete()
    {
        $this->assertTrue($this->fileSystem->deleteImage('test/test', $this->image));
    }

    public function testFileSystemAdapterSaveException()
    {
        $resolver = $this->getMock('ImgMan\Storage\Adapter\FileSystem\Resolver\ResolverDefault');
        $resolver->expects($this->any())
            ->method('resolveName')
            ->will($this->returnCallback(function () { throw new Exception(); }));
        $this->fileSystem->setResolver($resolver);

        $image = new Container(__DIR__ . '/../../../Image/img/test.jpg');
        $this->assertFalse($this->fileSystem->saveImage('test/test', $image));
    }

    public function testFileSystemAdapterDeleteException()
    {
        $resolver = $this->getMock('ImgMan\Storage\Adapter\FileSystem\Resolver\ResolverDefault');
        $resolver->expects($this->any())
            ->method('resolveName')
            ->will($this->returnCallback(function () { throw new Exception(); }));
        $this->fileSystem->setResolver($resolver);

        $this->assertFalse($this->fileSystem->deleteImage('test/test'));
    }

    public function testFileSystemAdapterHasException()
    {
        $resolver = $this->getMock('ImgMan\Storage\Adapter\FileSystem\Resolver\ResolverDefault');
        $resolver->expects($this->any())
            ->method('resolveName')
            ->will($this->returnCallback(function () { throw new Exception(); }));
        $this->fileSystem->setResolver($resolver);

        $this->assertFalse($this->fileSystem->hasImage('test/test'));
    }

    public function testFileSystemAdapterGetException()
    {
        $resolver = $this->getMock('ImgMan\Storage\Adapter\FileSystem\Resolver\ResolverDefault');
        $resolver->expects($this->any())
            ->method('resolveName')
            ->will($this->returnCallback(function () { throw new Exception(); }));
        $this->fileSystem->setResolver($resolver);

        $this->assertFalse($this->fileSystem->getImage('test/test'));
    }
}
