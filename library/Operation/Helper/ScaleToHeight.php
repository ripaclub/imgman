<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 10.35
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\Adapter\AdapterInterface;

class ScaleToHeight extends AbstractHelper
{
    /**
     * @param int $height
     */
    public function __invoke($height)
    {
        $oldWidth = $this->getAdapter()->getWidth();
        $oldHeight = $this->getAdapter()->getHeight();

        if ($oldHeight == $height) {
            return;
        }

        $newheight = $height;
        $newWidth = $oldWidth * $height / $oldHeight;

        $this->resize($newWidth, $newheight);
    }
}
