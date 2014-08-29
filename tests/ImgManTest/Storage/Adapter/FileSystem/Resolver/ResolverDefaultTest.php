<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage\Adapter\FileSystem\Resolver;

use ImgMan\Storage\Adapter\FileSystem\Resolver\ResolverDefault;
use ImgManTest\ImageManagerTestCase;

class ResolverDefaultTest extends ImageManagerTestCase
{
    public $resolver;

    public function setUp()
    {
        $this->resolver = new ResolverDefault();
    }

    /**
     * @expectedException \ImgMan\Storage\Adapter\FileSystem\Resolver\Exception\PathNotExistException
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

    /**
     * @expectedException \ImgMan\Storage\Adapter\FileSystem\Resolver\Exception\PathGeneratorException
     */
    public function testResolverPathException()
    {
        error_reporting(E_ERROR);
        $path = __DIR__ . '/test2';
        $id = "/test/test";

        $pathResult = $this->resolver->resolvePathDir($path, $id);
    }
} 