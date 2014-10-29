<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper;

use ImgMan\Operation\Helper\Options\WidthOptionTrait;

/**
 * Class ScaleToWidth
 */
class ScaleToWidth extends AbstractHelper
{
    use WidthOptionTrait;

    /**
     * @param $width
     * @return bool
     */
    public function __invoke($width)
    {
        $oldWidth = $this->getAdapter()->getWidth();
        $oldHeight = $this->getAdapter()->getHeight();

        if ($oldWidth == $width) {
            return false;
        }

        $newHeight = $oldHeight * $width / $oldWidth;

        return $this->getAdapter()->resize($width, $newHeight);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getWidth());
    }
}
