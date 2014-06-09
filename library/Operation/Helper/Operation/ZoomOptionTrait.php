<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 31/05/14
 * Time: 15.00
 */

namespace ImgManLibrary\Operation\Helper\Operation;


use Zend\Stdlib\AbstractOptions;

trait ZoomOptionTrait
{
    use AbstractOptionTrait;

    protected $zoom;

    /**
     * @param mixed $zoom
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
    }

    /**
     * @return mixed
     */
    public function getZoom()
    {
        return $this->zoom;
    }
}