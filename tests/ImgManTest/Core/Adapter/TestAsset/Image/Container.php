<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Core\Adapter\TestAsset\Image;

use ImgMan\BlobInterface;
use ImgMan\Image\Exception;

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