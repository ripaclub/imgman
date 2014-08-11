<?php
namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Operation\Helper\Options\HeightWidthAllowupBackgroundOptionTrait;

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

        $result = $this->getAdapter()->resize(round($newWidth), round($newHeight));

        if ($width != $newWidth || $height != $newHeight) {


            $imageBackground = $this->getAdapter()->create($width, $height, $this->getFormat(), $backgroundColor);
            $shiftHeight = round(($height - $newHeight) / 2);
            $shiftWidth  = round(($width - $newWidth) / 2);
            $result = $this->getAdapter()->compose($imageBackground, $shiftWidth, $shiftHeight);
        }

        return $result;
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