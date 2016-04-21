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

/**
 * Interface ImageInterface
 *
 */
interface ImageInterface extends BlobInterface
{
    /**
     * @param $mimeType string
     * @return $this
     */
    public function setMimeType($mimeType);

    /**
     * @return string|null
     */
    public function getMimeType();

    /**
     * @param $size string
     * @return $this
     */
    public function setSize($size);

    /**
     * @return string|null
     */
    public function getSize();
}