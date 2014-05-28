<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 12.33
 */

namespace ImgManLibrary\Operation\Helper;


use ImgManLibrary\Core\Adapter\AdapterInterface;

class FitIn implements HelperInterface
{
    protected $adapter;
    /**
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return mixed
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param $width
     * @param $height
     * @param bool $allowUpsample
     * @param null $backgroundColor
     */
    public function __invoke($width, $height, $allowUpsample = false, $backgroundColor = null)
    {
        $oldWidth = $this->getAdapter()->getWidth();
        $oldHeight = $this->getAdapter()->getHeight();

        $divX = $oldWidth / $width;
        $divY = $oldHeight / $height;

        $ratio = $this->getAdapter()->getRatio();

        if ($oldWidth >= $width || $oldHeight >= $height) {
            if ($divX > $divY) {
                $newWidth = $width;
                $newHeight = $newWidth / $ratio;
            } else {
                $newHeight = $height;
                $newWidth = $newHeight * $ratio;
            }
        } elseif ($allowUpsample && $divX > $divY) {
            $newWidth = $width;
            $newHeight = $newWidth / $ratio;
        } elseif ($allowUpsample) {
            $newHeight = $height;
            $newWidth = $newHeight * $ratio;
        } else {
            $newWidth = $oldWidth;
            $newHeight = $oldHeight;
        }

        $this->getAdapter()->resize(round($newWidth), round($newHeight));

        /*
        if ($width != $newWidth || $height != $newHeight) {
            $this->selfCompose($width, $height, round($width - $newWidth) / 2, round($height - $newHeight) / 2, $backgroundColor);
        }
        */
    }
} 