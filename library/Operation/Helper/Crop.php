<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 12.33
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Operation\Helper\Operation\CropOptionTrait;

class Zoom extends AbstractHelper
{
    use CropOptionTrait;

    /**
     * @param $x
     * @param $y
     * @param $with
     * @param $height
     * @return mixed
     */
    public function __invoke($x, $y, $with, $height)
    {
         return $this->getAdapter()->crop($x, $y, $with, $height);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getX(), $this->getY(), $this->getWith(), $this->getHeight());
    }
} 