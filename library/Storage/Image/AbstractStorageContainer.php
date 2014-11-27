<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Image;

use ImgMan\BlobInterface;

/**
 * Class AbstractImageContainer
 */
abstract class AbstractStorageContainer implements BlobInterface
{
    /**
     * @var string
     */
    protected $blob;

    /**
     * @var string
     */
    protected $mime_type;

    /**
     * @return string
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * @param string $blob
     * @return AbstractImageContainer
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }

    /**
     * @param string $mime_type
     */
    public function setMimeType($mime_type)
    {
        $this->mime_type = $mime_type;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }
}
