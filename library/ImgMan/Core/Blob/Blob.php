<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Core\Blob;

use ImgMan\BlobInterface;

/**
 * Class Blob
 */
class Blob implements BlobInterface
{
    /**
     * @var string
     */
    protected $blob;

    /**
     * @return string
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * @param string $blob
     * @return Blob
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }
}
