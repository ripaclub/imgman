<?php
namespace ImgManLibraryTest\Storage\Adapter\FileSystem\Resolver;

use ImgManLibrary\Storage\Adapter\FileSystem\Resolver\ResolverDefault;
use ImgManLibraryTest\ImageManagerTestCase;

class ResolverDefaultTest extends ImageManagerTestCase
{
    public $resolver;

    public function setUp()
    {
        $this->resolver = new ResolverDefault();
    }

    /**
     * @expectedException \ImgManLibrary\Storage\Adapter\FileSystem\Resolver\Exception\PathNotExistException
     */
    public function testResolverException()
    {
        $path = __DIR__ . '/testWrong';
        $id = "/test/test";

        $this->resolver->resolvePathDir($path, $id);
    }

    public function testResolverPath()
    {
        $path = __DIR__ . '/test';
        $id = "/test/test";

        $pathResult = $this->resolver->resolvePathDir($path, $id);

        $this->assertNotEmpty($pathResult);
        $this->assertNotEmpty($this->resolver->resolvePathDir($path, $id));

        rmdir($pathResult);
    }

    public function testResolverName()
    {
        $id = "/test/test";

        $name = $this->resolver->resolveName($id);
        $this->assertNotEmpty($name);
    }
} 