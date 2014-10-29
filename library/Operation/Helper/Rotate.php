<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper;

use ImgMan\Operation\Helper\Options\DegreesBackgroundOptionTrait;

/**
 * Class Rotate
 */
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
