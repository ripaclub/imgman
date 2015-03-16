<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest;

use ImgMan\BlobTrait;

class BlobTraitTest extends ImageManagerTestCase
{
    /**
     * @var BlobTrait
     */
    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgMan\BlobTrait');
    }

    public function testPluginManagerAwareTraitTest()
    {
        $this->traitObject->setBlob('test');
        $this->assertEquals('test', $this->traitObject->getBlob());
    }
}
