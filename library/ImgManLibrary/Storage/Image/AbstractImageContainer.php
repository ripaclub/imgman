<?php
namespace ImgManLibrary\Storage\Image;

use ImgManLibrary\BlobInterface;

abstract class AbstractImageContainer implements BlobInterface
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