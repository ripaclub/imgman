<?php

namespace ImgManLibraryTest\Operation\Helper\Options\TestAssets;

use \ImgManLibrary\Operation\Helper\Options\AbstractOptionTrait;

class GenericOptions {

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