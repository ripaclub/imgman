<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\FileSystem;

use ImgMan\BlobInterface;
use ImgMan\Storage\Adapter\FileSystem\Resolver\ResolvePathInterface;
use ImgMan\Storage\StorageInterface;

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
     * @param string $path
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param ResolvePathInterface $resolver
     * @return self
     */
    public function setResolver(ResolvePathInterface $resolver)
    {
        $this->resolver = $resolver;
        return $this;
    }

    /**
     * @return ResolvePathInterface
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
     * @return string|null
     */
    public function getImage($id)
    {
        try {
            $image = $this->_buildPathImage($id);
            // TODO container to image
            return file_get_contents($image);

        } catch (\Exception $e) {
            return false;
        }return false;
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