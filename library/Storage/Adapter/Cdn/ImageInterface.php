<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn;

use ImgMan\Image\ImageInterface as BaseImageInterface;

interface ImageInterface extends BaseImageInterface
{
    /**
     * @return string|null
     */
    public function getSrc();

    /**
     * @param string $src
     * @return $this
     */
    public function setSrc($src);
}