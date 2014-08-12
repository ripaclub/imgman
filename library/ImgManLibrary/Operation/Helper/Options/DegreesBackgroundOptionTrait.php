<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 31/05/14
 * Time: 15.00
 */

namespace ImgManLibrary\Operation\Helper\Options;

trait DegreesBackgroundOptionTrait
{
    use AbstractOptionTrait;

    protected $degrees;

    protected $background;

    /**
     * @param int $degrees
     */
    public function setDegrees($degrees)
    {
        $this->degrees = $degrees;
    }

    /**
     * @return int
     */
    public function getDegrees()
    {
        return $this->degrees;
    }

    /**
     * @param string $background
     */
    public function setBackground($background)
    {
        $this->background = $background;
    }

    /**
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }


}