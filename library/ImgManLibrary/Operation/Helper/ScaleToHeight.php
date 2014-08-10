<?php
namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\CoreInterface;
use ImgManLibrary\Operation\Helper\Options\HeightOptionTrait;

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
