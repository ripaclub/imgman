<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 31/05/14
 * Time: 15.00
 */

namespace ImgManLibrary\Operation\Helper\Options;

trait HeightWidthAllowupBackgroundOptionTrait
{
    use AbstractOptionTrait;

    protected $height;

    protected $width;

    protected $allowUpsample = false;

    protected $backgroundColor = null;

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
     * @param bool $allowUpsample
     */
    public function setAllowUpsample($allowUpsample)
    {
        $this->allowUpsample = $allowUpsample;
    }

    /**
     * @return bool
     */
    public function getAllowUpsample()
    {
        return $this->allowUpsample;
    }

    /**
     * @param string $backgroundColor
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }


}