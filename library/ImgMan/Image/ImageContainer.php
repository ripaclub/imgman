<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Image;

use ImgMan\BlobInterface;
use ImgMan\Image\Exception;

class ImageContainer implements BlobInterface
{
    protected $blob;

    public function __construct($img)
    {
        $content = file_get_contents($img);

        if ($content === false) {
            throw new Exception\FileNotFound($img . ' file not found');

        } else {
            $this->setBlob($content);

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
     * @param string $blob
     * @return ImageContainer
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }
}
