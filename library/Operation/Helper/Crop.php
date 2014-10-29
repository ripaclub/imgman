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

/**
 * Class Crop
 */
class Crop extends AbstractHelper
{
    use XYWidthHeightOptionTrait;

    /**
     * @param $cordX
     * @param $cordY
     * @param $width
     * @param $height
     * @return bool
     */
    public function __invoke($cordX, $cordY, $width, $height)
    {
         return $this->getAdapter()->crop($cordX, $cordY, $width, $height);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getCordX(), $this->getCordY(), $this->getWidth(), $this->getHeight());
    }
}
