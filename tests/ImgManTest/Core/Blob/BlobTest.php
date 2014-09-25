<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Core\Blob;

use ImgMan\Core\Blob\Blob;
use ImgManTest\ImageManagerTestCase;

/**
 * Class BlobTest
 */
class BlobTest extends ImageManagerTestCase
{
    /**
     * @var Blob
     */
    protected $blob;

    public function setUp()
    {
        $this->blob = new Blob();
    }

    public function testImagickCoreBlob()
    {
        $this->blob->setBlob('test');
        $this->assertEquals($this->blob->getBlob(), 'test');
    }
}
