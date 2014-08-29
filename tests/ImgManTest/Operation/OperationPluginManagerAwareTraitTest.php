<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Operation;

use ImgManTest\ImageManagerTestCase;

class OperationPluginManagerAwareTraitTest extends ImageManagerTestCase
{
    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgMan\Operation\PluginManagerAwareTrait');
    }

    public function testPluginManagerAwareTraitTest()
    {
        $this->traitObject->setPluginManager($this->getMock('Zend\ServiceManager\AbstractPluginManager'));
        $this->assertInstanceOf('Zend\ServiceManager\AbstractPluginManager',  $this->traitObject->getPluginManager());
    }
}
