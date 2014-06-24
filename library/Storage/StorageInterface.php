<?php
namespace ImgManLibrary\Storage;

use ImgManLibrary\BlobInterface;
use ImgManLibrary\Storage\Image\AbstractImageContainer;

interface StorageInterface
{

    /**
     * @param $id
     * @param BlobInterface $blob
     * @return bool
     */
    public function saveImage($id, BlobInterface $blob);

    /**
     * @param $id
     * @param BlobInterface $blob
     * @return bool
     */
    public function updateImage($id, BlobInterface $blob);

    /**
     * @param $id
     * @return bool
     */
    public function deleteImage($id);

    /**
     * @param $id
     * @return AbstractImageContainer
     */
    public function getImage($id);

    /**
     * @param $id
     * @return bool
     */
    public function hasImage($id);
} 