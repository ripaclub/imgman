<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\FileSystem\Resolver;

interface ResolvePathInterface
{
    /**
     * @param string $path
     * @param string $id
     * @return string
     */
    public function resolvePathDir($path, $id);

    /**
     * @param string $id
     * @return string
     */
    public function resolveName($id);
} 