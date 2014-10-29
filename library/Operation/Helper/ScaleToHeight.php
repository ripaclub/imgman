<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper;

use ImgMan\Operation\Helper\Options\HeightOptionTrait;

/**
 * Class ScaleToHeight
 */
class ScaleToHeight extends AbstractHelper
{
    use HeightOptionTrait;

    /**
     * @param $height
     * @return bool
     */
    public function __invoke($height)
    {
        $oldWidth = $this->getAdapter()->getWidth();
        $oldHeight = $this->getAdapter()->getHeight();

        if ($oldHeight == $height) {
            return false;
        }

        $newWidth = $oldWidth * $height / $oldHeight;

        return $this->getAdapter()->resize($newWidth, $height);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getHeight());
    }
}
