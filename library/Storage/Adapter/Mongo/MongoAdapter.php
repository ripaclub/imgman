<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 08/06/14
 * Time: 15.48
 */

namespace ImgManLibrary\Storage\Adapter\Mongo;

use ImgManLibrary\BlobInterface;
use ImgManLibrary\Storage\StorageInterface;
use MongoCollection;

class MongoAdapter extends MongoCollection implements StorageInterface
{
    /**
     * @param $id
     * @param BlobInterface $blob
     * @return bool
     */
    public function saveImage($id, BlobInterface $blob)
    {

        $document = array(
            '_id' => new \MongoId(),
            'identifier'   => $id,
            'contentImage' =>  md5($blob->getBlob())
        );
        try {
            var_dump($id);
        return $this->save($document);
        } catch (\Exception $e) {
            /* @var $e \Exception */
            var_dump($e->getMessage());
            var_dump($e->getCode());
        }

    }

    /**
     * @param $id
     * @param BlobInterface $blob
     * @return bool
     */
    public function updateImage($id, BlobInterface $blob)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteImage($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getImage($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasImage($id)
    {
        // TODO: Implement has() method.
    }
} 