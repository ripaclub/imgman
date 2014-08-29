<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Core\Adapter\TestAsset\Image;

use ImgMan\BlobInterface;

class WrongImage implements BlobInterface
{
    public function getBlob()
    {
        return 'test';
    }

    public function setBlob($blog)
    {
        // TODO: Implement setBlog() method.
    }

}