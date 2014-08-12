<?php
namespace ImgManLibrary\Storage;

use ImgManLibrary\BlobInterface;
use ImgManLibrary\Storage\Image\AbstractImageContainer;

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