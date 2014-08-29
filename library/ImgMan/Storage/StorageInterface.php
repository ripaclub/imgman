<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage;

use ImgMan\BlobInterface;
use ImgMan\Storage\Image\AbstractImageContainer;

interface StorageInterface
{

    /**
     * @param string $id
     * @param BlobInterface $blob
     * @return bool
     */
    public function saveImage($id, BlobInterface $blob);

    /**
     * @param string $id
     * @param BlobInterface $blob
     * @return bool
     */
    public function updateImage($id, BlobInterface $blob);

    /**
     * @param string $id
     * @return bool
     */
    public function deleteImage($id);

    /**
     * @param string $id
     * @return AbstractImageContainer|null
     */
    public function getImage($id);

    /**
     * @param string $id
     * @return bool
     */
    public function hasImage($id);
} 