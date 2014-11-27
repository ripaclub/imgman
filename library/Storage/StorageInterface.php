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
use ImgMan\Storage\Image\AbstractStorageContainer;

/**
 * Interface StorageInterface
 */
interface StorageInterface
{

    /**
     * @param string $identifier
     * @param BlobInterface $blob
     * @return bool
     */
    public function saveImage($identifier, BlobInterface $blob);

    /**
     * @param string $identifier
     * @param BlobInterface $blob
     * @return bool
     */
    public function updateImage($identifier, BlobInterface $blob);

    /**
     * @param string $identifier
     * @return bool
     */
    public function deleteImage($identifier);

    /**
     * @param string $identifier
     * @return AbstractStorageContainer|null
     */
    public function getImage($identifier);

    /**
     * @param string $identifier
     * @return bool
     */
    public function hasImage($identifier);
}
