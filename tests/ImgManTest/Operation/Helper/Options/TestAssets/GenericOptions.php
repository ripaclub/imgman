<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Operation\Helper\Options\TestAssets;

use \ImgMan\Operation\Helper\Options\AbstractOptionTrait;

class GenericOptions
{
    use AbstractOptionTrait;

    protected $testField;

    public function setTestField($value)
    {
        $this->testField = $value;
    }

    public function getTestField()
    {
        return $this->testField;
    }
}
