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
use ImgMan\Storage\Adapter\FileSystem\Image\ImageContainer;
use ImgMan\Storage\Adapter\FileSystem\Resolver\ResolvePathInterface;
use ImgMan\Storage\StorageInterface;

/**
 * Class FileSystemAdapter
 */
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
     * Fileinfo magic database resource
     *
     * This variable is populated the first time _detectFileMimeType is called
     * and is then reused on every call to this method
     *
     * @var resource
     */
    protected static $fileInfoDb = null;

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
     * @param $identifier
     * @param BlobInterface $blob
     * @return bool
     */
    public function saveImage($identifier, BlobInterface $blob)
    {
        try {
            $image = $this->_buildPathImage($identifier);
            return (bool) file_put_contents($image, $blob->getBlob());
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @return bool
     */
    public function updateImage($identifier, BlobInterface $blob)
    {
        return $this->saveImage($identifier, $blob);
    }

    /**
     * @param $identifier
     * @return bool
     */
    public function deleteImage($identifier)
    {
        try {
            $image = $this->_buildPathImage($identifier);
            return unlink($image);

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $identifier
     * @return string|null
     */
    public function getImage($identifier)
    {
        try {
            $image = $this->_buildPathImage($identifier);
            $imgContainer = new ImageContainer($image);
            $imgContainer->setBlob(file_get_contents($image));
            var_dump($this->detectFileMimeType($image));
            $imgContainer->setMimeType($this->detectFileMimeType($image));
            return $imgContainer;

        } catch (\Exception $e) {
            return false;
        }return false;
    }

    /**
     * @param $identifier
     * @return bool
     */
    public function hasImage($identifier)
    {
        try {
            $image = $this->_buildPathImage($identifier);
            return file_exists($image);

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $identifier
     * @return string
     */
    private function _buildPathImage($identifier)
    {
        $path = $this->resolver->resolvePathDir($this->getPath(), $identifier);
        $name = $this->resolver->resolveName($identifier);
        return $path . '/' . $name;
    }

    /**
     * @param $file
     * @return mixed|null|string
     */
    protected function detectFileMimeType($file)
    {
        $type = null;

        if (function_exists('mime_content_type')) {
            $type = mime_content_type($file);
        }

        // Fallback to the default application/octet-stream
        if (! $type) {
            $type = 'application/octet-stream';
        }

        return $type;
    }
}
