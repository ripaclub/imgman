<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper\Options;

trait DegreesBackgroundOptionTrait
{
    use AbstractOptionTrait;

    protected $degrees;

    protected $background;

    /**
     * @param int $degrees
     */
    public function setDegrees($degrees)
    {
        $this->degrees = $degrees;
    }

    /**
     * @return int
     */
    public function getDegrees()
    {
        return $this->degrees;
    }

    /**
     * @param string $background
     */
    public function setBackground($background)
    {
        $this->background = $background;
    }

    /**
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }


}
