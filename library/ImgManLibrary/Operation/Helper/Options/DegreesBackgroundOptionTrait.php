<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 31/05/14
 * Time: 15.00
 */

namespace ImgManLibrary\Operation\Helper\Options;


use Zend\Stdlib\AbstractOptions;

trait DegreesBackgroundOptionTrait
{
    use AbstractOptionTrait;

    protected $degrees;

    protected $background;

    /**
     * @param mixed $degrees
     */
    public function setDegrees($degrees)
    {
        $this->degrees = $degrees;
    }

    /**
     * @return mixed
     */
    public function getDegrees()
    {
        return $this->degrees;
    }

    /**
     * @param mixed $background
     */
    public function setBackground($background)
    {
        $this->background = $background;
    }

    /**
     * @return mixed
     */
    public function getBackground()
    {
        return $this->background;
    }


}