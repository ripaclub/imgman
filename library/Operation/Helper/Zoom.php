<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 12.33
 */

namespace ImgManLibrary\Operation\Helper;


use ImgManLibrary\Core\CoreInterface;

class Zoom extends AbstractHelper
{
    /**
     * @param float $zoom
     */
    public function __invoke($zoom)
    {
        $newWidth = $this->getAdapter()->getWidth() * $zoom / 100;
        $newHeight = $this->getAdapter()->getHeight($this) * $zoom / 100;

        $this->getAdapter()->resize($newHeight, $newWidth);
    }

    /**
     * @param array $params
     */
    public function execute(array $params)
    {
        // TODO: Implement execute() method.
    }
} 