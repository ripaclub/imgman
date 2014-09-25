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
use ImgMan\Image\Exception\FileNotFound;

/**
 * Class ImageContainer
 */
class ImageContainer implements BlobInterface
{
    protected $blob;

    /**
     * Ctor
     * @param $img
     * @throws FileNotFound
     */
    public function __construct($img)
    {
        $content = file_get_contents($img);

        if ($content === false) {
            throw new FileNotFound($img . ' file not found');

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
