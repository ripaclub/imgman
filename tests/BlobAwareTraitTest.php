<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest;

use ImgMan\BlobAwareTrait;
use ImgManTest\TestAsset\BlobAsset;

/**
 * Class BlobAwareTraitTest
 */
class BlobAwareTraitTest extends ImageManagerTestCase
{
    /**
     * @var BlobAwareTrait
     */
    protected $traitObject;

    public function setUp()
    {
        $this->traitObject = $this->getObjectForTrait('ImgMan\BlobAwareTrait');
    }

    public function testBloAwareTraitGetSetBlob()
    {
        $blobObject = new BlobAsset();
        $this->traitObject->setBlob($blobObject);
        $this->assertEquals($blobObject, $this->traitObject->getBlob());
    }
}
