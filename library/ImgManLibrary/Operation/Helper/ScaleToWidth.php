<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 10.35
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Operation\Helper\Options\WidthOptionTrait;

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
