<?php
/**
 * Created by PhpStorm.
 * User: visa
 * Date: 18/04/16
 * Time: 19.34
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