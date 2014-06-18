<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 16/06/14
 * Time: 10.22
 */

namespace ImgManLibraryTest\Core\Adapter\TestAsset\Image;

use ImgManLibrary\BlobInterface;
use ImgManLibrary\Image\Exception;

class Container implements BlobInterface
{
    protected $blob;

    function __construct($img)
    {
        try {
            $this->setBlob(file_get_contents($img));
        }
        catch (\Exception $e) {
            throw new Exception\FileNotFound($img . ' file not found');
        }

        if ($this->getBlob() === false) {
            throw new Exception\FileNotFound($img . ' file not found');
        }
    }

    /**
     * @return string
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * @param $blob
     * @return ImageEntity
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }
} 