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
    public function resolvePathDir($path, $id);

    public function resolveName($id);
} 