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
use ImgMan\Core\Blob\Blob;
use ImgMan\Image\Exception;
use ImgMan\Image\ImageContainer;

/**
 * Class Container
 */
class Container implements BlobInterface
{
    /**
     * @var Blob
     */
    protected $blob;

    /**
     * Ctor
     * @param $img
     */
    public function __construct($img)
    {
        try {
            $this->setBlob(file_get_contents($img));
        } catch (\Exception $e) {
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
     * @return ImageContainer
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }
}
