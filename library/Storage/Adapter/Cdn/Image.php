<?php
namespace ImgMan\Storage\Adapter\Cdn;

use ImgMan\Image\Image as BaseImage;

class Image extends BaseImage
{
    protected $src;

    /**
     * @return string|null
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param string $src
     * @return $this
     */
    public function setSrc($src)
    {
        $this->src = $src;
        return $this;
    }
}