<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 31/05/14
 * Time: 15.00
 */

namespace ImgManLibrary\Operation\Helper\Options;

trait WidthOptionTrait
{
    use AbstractOptionTrait;

    protected $width;

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