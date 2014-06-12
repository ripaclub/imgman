<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 10.35
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\CoreInterface;
use ImgManLibrary\Operation\Helper\Operation\HeightOptionTrait;

class ScaleToHeight extends AbstractHelper
{
    use HeightOptionTrait;

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

        $newHeight = $height;
        $newWidth = $oldWidth * $height / $oldHeight;

        return $this->resize($newWidth, $newHeight);
    }

    /**
     * @param array $params
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getHeight());
    }
}
