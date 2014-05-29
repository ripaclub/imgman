<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 10.35
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\Adapter\AdapterInterface;

class ScaleToWith extends AbstractHelper
{
    /**
     * @param int $width
     */
    public function __invoke($width)
    {
        $oldWidth = $this->getAdapter()->getWidth();
        $oldHeight = $this->getAdapter()->getHeight();

        if ($oldWidth == $width) {
            return;
        }

        $newWidth = $width;
        $newHeight = $oldHeight * $width / $oldWidth;

        $this->getAdapter()->resize($newWidth, $newHeight);
    }
}
