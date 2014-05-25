<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 1.14
 */

namespace ImgManLibrary\Core;

use ImgManLibrary\BlobInterface;

class ImageContenitor implements BlobInterface
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
     * @return ImageContenitor
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }

} 