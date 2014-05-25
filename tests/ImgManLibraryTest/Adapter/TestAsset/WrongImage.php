<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 23/05/14
 * Time: 14.12
 */

namespace ImgManLibraryTest\Adapter\TestAsset;

use ImgManLibrary\BlobInterface;

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