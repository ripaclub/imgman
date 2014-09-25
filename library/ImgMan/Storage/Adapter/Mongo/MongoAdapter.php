<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Mongo;

use ImgMan\BlobInterface;
use ImgMan\Storage\Adapter\Mongo\Image\ImageContainer;
use ImgMan\Storage\StorageInterface;
use MongoCollection;

/**
 * Class MongoAdapter
 */
class MongoAdapter implements StorageInterface
{
    /**
     * @var MongoCollection
     */
    protected $mongoCollection;

    /**
     * @param MongoCollection $mongoCollection
     * @return self
     */
    public function setMongoCollection(MongoCollection $mongoCollection)
    {
        $this->mongoCollection = $mongoCollection;
        return $this;
    }

    /**
     * @return MongoCollection
     */
    public function getMongoCollection()
    {
        return $this->mongoCollection;
    }

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @return bool
     */
    public function saveImage($identifier, BlobInterface $blob)
    {

        $document = [
            '_id' => new \MongoId(),
            'identifier'   => $identifier,
            'blob' => new \MongoBinData($blob->getBlob(), \MongoBinData::CUSTOM),
            'hash' =>  md5($blob->getBlob())
        ];

        return $this->getMongoCollection()->save($document);
    }

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @return bool
     */
    public function updateImage($identifier, BlobInterface $blob)
    {
        $field  = ['identifier' => $identifier];
        $modify = ['$set' => ['blob' => new \MongoBinData($blob->getBlob(), \MongoBinData::CUSTOM)]];
        $option = ['multiple' => true];

        return $this->getMongoCollection()->update($field, $modify, $option);
    }

    /**
     * @param $identifier
     * @return bool
     */
    public function deleteImage($identifier)
    {
        return $this->getMongoCollection()->remove(['identifier' => $identifier]);
    }

    /**
     * @param $identifier
     * @return \ImgMan\Storage\Image\AbstractImageContainer|null
     */
    public function getImage($identifier)
    {
        $image = $this->getMongoCollection()->findOne(['identifier' => $identifier]);

        if ($image) {
            $imgContainer = new ImageContainer();
            return $imgContainer->setBlob($image['blob']->bin);

        } else {
            return null;
        }
    }

    /**
     * @param $identifier
     * @return bool
     */
    public function hasImage($identifier)
    {
        $image = $this->getMongoCollection()->findOne(['identifier' => $identifier]);
        if ($image) {
            return true;
        } else {
            return false;
        }
    }
}
