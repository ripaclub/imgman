<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 12.33
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Operation\Helper\Operation\XYWidthHeightOptionTrait;

class Crop extends AbstractHelper
{
    use XYWidthHeightOptionTrait;

    /**
     * @param $x
     * @param $y
     * @param $width
     * @param $height
     * @return mixed
     */
    public function __invoke($x, $y, $width, $height)
    {
         return $this->getAdapter()->crop($x, $y, $width, $height);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getX(), $this->getY(), $this->getWidth(), $this->getHeight());
    }
} 