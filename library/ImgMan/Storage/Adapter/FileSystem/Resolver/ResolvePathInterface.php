<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\FileSystem\Resolver;

/**
 * Interface ResolvePathInterface
 */
interface ResolvePathInterface
{
    /**
     * @param string $path
     * @param string $identifier
     * @return string
     */
    public function resolvePathDir($path, $identifier);

    /**
     * @param $identifier
     * @return mixed
     */
    public function resolveName($identifier);
}
