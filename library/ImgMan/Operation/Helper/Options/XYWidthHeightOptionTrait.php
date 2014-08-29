<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper\Options;

trait XYWidthHeightOptionTrait
{
    use AbstractOptionTrait;

     protected $cordX, $cordY, $width, $height;

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param $cordY
     */
    public function setCordY($cordY)
    {
        $this->cordY = $cordY;
    }

    /**
     * @return int
     */
    public function getCordY()
    {
        return $this->cordY;
    }

    /**
     * @param $cordX
     */
    public function setCordX($cordX)
    {
        $this->cordX = $cordX;
    }

    /**
     * @return int
     */
    public function getCordX()
    {
        return $this->cordX;
    }
}
