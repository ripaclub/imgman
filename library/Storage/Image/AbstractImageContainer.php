<?php
namespace ImgManLibrary\Storage\Image;

use ImgManLibrary\BlobInterface;

abstract class AbstractImageContainer implements BlobInterface
{
    /**
     * @var string
     */
    protected $blob;

    protected $mime_type;

    /**
     * @return blob
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * @param $blob
     * @return AbstractImageContainer
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }

    /**
     * @param mixed $mime_type
     */
    public function setMimeType($mime_type)
    {
        $this->mime_type = $mime_type;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }


} 