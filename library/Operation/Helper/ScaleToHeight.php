<?php
namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\CoreInterface;
use ImgManLibrary\Operation\Helper\Operation\HeightOptionTrait;

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

        $newHeight = $height;
        $newWidth = $oldWidth * $height / $oldHeight;

        return $this->getAdapter()->resize($newWidth, $newHeight);
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
