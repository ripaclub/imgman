<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper;

use ImgMan\Operation\Helper\Options\HeightWidthOptionTrait;

class Resize extends AbstractHelper
{
    use HeightWidthOptionTrait;

    /**
     * @param $width
     * @param $height
     * @return bool
     */
    public function __invoke($width, $height)
    {
        return $this->getAdapter()->resize($width,  $height);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getWidth(), $this->getHeight());
    }

}