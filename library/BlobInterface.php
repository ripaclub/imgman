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
 * Interface BlobInterface
 */
interface BlobInterface
{
    /**
     * @return string
     */
    public function getBlob();

    /**
     * @param string $blob
     * @return BlobInterface
     */
    public function setBlob($blob);
}
