<?php
namespace ImgManLibrary\Storage\Adapter\FileSystem;

use ImgManLibrary\BlobInterface;
use ImgManLibrary\Storage\Adapter\FileSystem\Resolver\ResolvePathInterface;
use ImgManLibrary\Storage\StorageInterface;

class FileSystemAdapter implements StorageInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var ResolvePathInterface
     */
    protected $resolver;

    /**
     * @param $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $resolver
     */
    public function setResolver(ResolvePathInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @return mixed
     */
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * @param $id
     * @param BlobInterface $blob
     * @return bool
     */
    public function saveImage($id, BlobInterface $blob)
    {
        try {
            $image = $this->_buildPathImage($id);
            return (bool) file_put_contents($image, $blob->getBlob());
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $id
     * @param BlobInterface $blob
     * @return bool
     */
    public function updateImage($id, BlobInterface $blob)
    {
        return $this->saveImage($id, $blob);
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteImage($id)
    {
        try {
            $image = $this->_buildPathImage($id);
            return unlink($image);

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool|\ImgManLibrary\Storage\Image\AbstractImageContainer|string
     */
    public function getImage($id)
    {
        try {
            $image = $this->_buildPathImage($id);
            return file_get_contents($image);

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasImage($id)
    {
        try {
            $image = $this->_buildPathImage($id);
            return file_exists($image);

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $id
     * @return string
     */
    private function _buildPathImage($id)
    {
        $path = $this->resolver->resolvePathDir($this->getPath(), $id);
        $name = $this->resolver->resolveName($id);
        return $path . '/' . $name;
    }
} 