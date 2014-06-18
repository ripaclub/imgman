<?php
namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Operation\Helper\Operation\HeightWidthAllowupBackgroundOptionTrait;

class FitOut extends AbstractHelper
{
    use HeightWidthAllowupBackgroundOptionTrait;

    /**
     * @param $width
     * @param $height
     * @param bool $allowUpsample
     * @param null $backgroundColor
     * @return bool
     */
    public function __invoke($width, $height, $allowUpsample = false, $backgroundColor = null)
    {
        $oldWidth = $this->getAdapter()->getWidth();
        $oldHeight = $this->getAdapter()->getHeight();

        $ratio = $oldWidth / $oldHeight;
        $divX = $oldWidth / $width;
        $divY = $oldHeight / $height;

        if ($divX < $divY) {
            $newWidth = !$allowUpsample && $oldWidth <= $width ? $oldWidth : $width;
            $newHeight = $newWidth / $ratio;
        } else {
            $newHeight = !$allowUpsample && $oldHeight <= $height ? $oldHeight : $height;
            $newWidth = $newHeight * $ratio;
        }

        return $this->getAdapter()->resize(round($newWidth), round($newHeight));
    }

    /**
     * @param array $params
     * @return bool
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getWidth(), $this->getHeight(), $this->getAllowUpsample(), $this->getBackgroundColor());
    }
} 