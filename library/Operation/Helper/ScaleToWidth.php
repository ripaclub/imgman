<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 10.35
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\CoreInterface;
use ImgManLibrary\Operation\Helper\Operation\WidthOptionTrait;

class ScaleToWidth extends AbstractHelper
{
    use WidthOptionTrait;

    /**
     * @param $width
     * @return mixed
     */
    public function __invoke($width)
    {
        $oldWidth = $this->getAdapter()->getWidth();
        $oldHeight = $this->getAdapter()->getHeight();

        if ($oldWidth == $width) {
            return false;
        }

        $newWidth = $width;
        $newHeight = $oldHeight * $width / $oldWidth;

        return $this->getAdapter()->resize($newWidth, $newHeight);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getWidth());
    }
}
