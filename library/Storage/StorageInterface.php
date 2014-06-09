<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 20/05/14
 * Time: 10.42
 */

namespace ImgManLibrary\Storage;

use ImgManLibrary\BlobInterface;

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
     * @return mixed
     */
    public function getImage($id);

    /**
     * @param $id
     * @return bool
     */
    public function hasImage($id);
} 