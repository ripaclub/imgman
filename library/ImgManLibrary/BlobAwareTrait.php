<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 23/05/14
 * Time: 14.16
 */

namespace ImgManLibrary;


trait BlobAwareTrait
{
    public $blob;

    /**
     * @param mixed $blob
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
    }

    /**
     * @return mixed
     */
    public function getBlob()
    {
        return $this->blob;
    }
} 