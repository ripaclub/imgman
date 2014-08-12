<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 31/05/14
 * Time: 15.00
 */

namespace ImgManLibrary\Operation\Helper\Options;

trait HeightWidthOptionTrait
{
    use AbstractOptionTrait;

    protected $height;

    protected $width;

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
}