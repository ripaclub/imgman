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
 * Interface BlobAwareInterface
 */
interface BlobAwareInterface
{
    /**
     * @return BlobInterface
     */
    public function getBlob();

    /**
     * @param BlobInterface $blob
     */
    public function setBlob(BlobInterface $blob);
}
