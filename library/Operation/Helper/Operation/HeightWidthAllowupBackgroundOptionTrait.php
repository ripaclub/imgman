<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 31/05/14
 * Time: 15.00
 */

namespace ImgManLibrary\Operation\Helper\Operation;


use Zend\Stdlib\AbstractOptions;

trait HeightWidthAllowupBackgroundOptionTrait
{
    use AbstractOptionTrait;

    protected $height;

    protected $width;

    protected $allowUpsample = false;

    protected $backgroundColor = null;

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $allowUpsample
     */
    public function setAllowUpsample($allowUpsample)
    {
        $this->allowUpsample = $allowUpsample;
    }

    /**
     * @return mixed
     */
    public function getAllowUpsample()
    {
        return $this->allowUpsample;
    }

    /**
     * @param mixed $backgroundColor
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @return mixed
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }


}