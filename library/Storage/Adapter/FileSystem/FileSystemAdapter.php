<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 11.11
 */

namespace ImgManLibrary\Storage\Adapter\FileSystem;

use ImgManLibrary\BlobInterface;
use ImgManLibrary\Storage\StorageInterface;

class FileSystemAdapter implements StorageInterface
{
    protected $path;

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    public function saveImage($id, BlobInterface $blob)
    {
        // TODO: Implement save() method.
    }

    public function updateImage($id, BlobInterface $blob)
    {
        // TODO: Implement update() method.
    }

    public function deleteImage($id)
    {
        // TODO: Implement delete() method.
    }

    public function getImage($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasImage($id)
    {
        // TODO: Implement has() method.
    }


} 