<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 10.35
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\CoreInterface;
use ImgManLibrary\Operation\Helper\Options\DegreesBackgroundOptionTrait;
use ImgManLibrary\Operation\Helper\Options\WidthOptionTrait;

class Rotate extends AbstractHelper
{
    use DegreesBackgroundOptionTrait;

    /**
     * @param $degrees
     * @param $background
     * @return mixed
     */
    public function __invoke($degrees, $background)
    {

        return $this->getAdapter()->rotate($degrees, $background);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getDegrees(), $this->getBackground());
    }
}
