<?php
namespace ImgManLibrary\Storage\Image;

use ImgManLibrary\BlobInterface;

abstract class AbstractImageContainer implements BlobInterface
{
    /**
     * @var string
     */
    protected $blob;

    protected $identifier;

    protected $rendition;

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
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $rendition
     */
    public function setRendition($rendition)
    {
        $this->rendition = $rendition;
    }

    /**
     * @return mixed
     */
    public function getRendition()
    {
        return $this->rendition;
    }
} 