<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper\Options;

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
