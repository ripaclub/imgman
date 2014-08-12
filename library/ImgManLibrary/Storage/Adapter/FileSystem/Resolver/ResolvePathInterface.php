<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 24/06/14
 * Time: 17.06
 */

namespace ImgManLibrary\Storage\Adapter\FileSystem\Resolver;


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