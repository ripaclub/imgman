<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 16/06/14
 * Time: 13.10
 */

namespace ImgManLibraryTest\Operation;

use ImgManLibraryTest\ImageManagerTestCase;

class OperationPluginManagerAwareTraitTest extends ImageManagerTestCase
{
    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgManLibrary\Operation\PluginManagerAwareTrait');
    }

    public function testPluginManagerAwareTraitTest()
    {
        $this->traitObject->setPluginManager($this->getMock('Zend\ServiceManager\AbstractPluginManager'));
        $this->assertInstanceOf('Zend\ServiceManager\AbstractPluginManager',  $this->traitObject->getPluginManager());
    }
} 