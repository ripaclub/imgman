<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan;

/**
 * Class BlobTrait
 *
 */
trait BlobTrait
{
    /**
     * @var string
     */
    protected $blob;

    /**
     * @return string|null
     */
    public function getBlob()
    {
        return $this->blob;
    }

    /**
     * @param $blob
     * @return $this
     */
    public function setBlob($blob)
    {
        $this->blob = $blob;
        return $this;
    }
}