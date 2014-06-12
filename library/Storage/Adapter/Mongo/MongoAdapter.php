<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 08/06/14
 * Time: 15.48
 */

namespace ImgManLibrary\Storage\Adapter\Mongo;

use ImgManLibrary\BlobInterface;
use ImgManLibrary\Storage\Adapter\Mongo\Image\ImageContainer;
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
            'blob' => new \MongoBinData($blob->getBlob(), \MongoBinData::CUSTOM),
            'hash' =>  md5($blob->getBlob())
        );

        return $this->save($document);
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
        return $this->remove(array('identifier' => $id));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getImage($id)
    {
        $image = $this->findOne(array('identifier' => $id));

        if ($image) {
            $imgContainer = new ImageContainer();
            var_dump($image['blob']);
            die();
            //$imgContainer->setBlob()

        } else {
            return null;
        }

        return $this->findOne(array('identifier' => $id));
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasImage($id)
    {
        $image = $this->findOne(array('identifier' => $id));
        if ($image) {
            return true;

        } else {

            return false;
        }
    }
} 