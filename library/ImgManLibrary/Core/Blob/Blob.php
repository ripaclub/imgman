<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 14.43
 */

namespace ImgManLibrary\Core\Blob;

use ImgManLibrary\BlobInterface;

class Blob implements BlobInterface
{
    protected $blob;

    /**
     * @return mixed
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * @param $blob
     * @return Blob
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }
}