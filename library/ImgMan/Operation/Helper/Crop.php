<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper;

use ImgMan\Operation\Helper\Options\XYWidthHeightOptionTrait;

class Crop extends AbstractHelper
{
    use XYWidthHeightOptionTrait;

    /**
     * @param $x
     * @param $y
     * @param $width
     * @param $height
     * @return bool
     */
    public function __invoke($x, $y, $width, $height)
    {
         return $this->getAdapter()->crop($x, $y, $width, $height);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getX(), $this->getY(), $this->getWidth(), $this->getHeight());
    }
} 