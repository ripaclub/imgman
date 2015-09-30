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
use ImgMan\Image\Image;
use ImgMan\Storage\StorageInterface;
use MongoCollection;
use Zend\Stdlib\ErrorHandler;

/**
 * Class MongoAdapter
 */
class MongoAdapter implements StorageInterface
{
    use HandleResultTrait;

    const DEFAULT_IDENTIFIER_NAME = '_id';

    /**
     * @var string
     */
    protected $identifierName;

    /**
     * @var MongoCollection
     */
    protected $mongoCollection;

    /**
     * Fileinfo magic database resource
     *
     * This variable is populated the first time _detectFileMimeType is called
     * and is then reused on every call to this method
     *
     * @var resource
     */
    protected static $fileInfoDb = null;

    /**
     * @param MongoCollection $mongoCollection
     * @return $this
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
            $this->getIdentifierName() => $identifier,
            'blob' => new \MongoBinData($blob->getBlob(), \MongoBinData::CUSTOM),
            'hash' =>  md5($blob->getBlob())
        ];

        $result = $this->getMongoCollection()->save($document);
        return $this->handleResult($result);
    }

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @return bool
     */
    public function updateImage($identifier, BlobInterface $blob)
    {
        $field  = [$this->getIdentifierName() => $identifier];
        $modify = ['$set' => ['blob' => new \MongoBinData($blob->getBlob(), \MongoBinData::CUSTOM)]];
        $option = ['multiple' => true];

        $result = $this->getMongoCollection()->update($field, $modify, $option);
        return $this->handleResult($result);
    }

    /**
     * @param $identifier
     * @return bool
     */
    public function deleteImage($identifier)
    {
        $result = $this->getMongoCollection()->remove([$this->getIdentifierName() => $identifier]);
        return $this->handleResult($result, true);
    }

    /**
     * @param $identifier
     * @return Image|null
     */
    public function getImage($identifier)
    {
        $image = $this->getMongoCollection()->findOne([$this->getIdentifierName() => $identifier]);

        if ($image) {
            $imgContainer = new Image();
            $imgContainer->setBlob($image['blob']->bin);
            $imgContainer->setSize(strlen($image['blob']->bin));
            $imgContainer->setMimeType($this->detectBufferMimeType($image['blob']->bin));
            return $imgContainer;
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
        $image = $this->getMongoCollection()->findOne([$this->getIdentifierName() => $identifier]);
        if ($image) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $buffer
     * @return string|null
     */
    protected function detectBufferMimeType($buffer)
    {
        $type = null;
        if (function_exists('finfo_open')) {
            if (static::$fileInfoDb === null) {
                ErrorHandler::start();
                static::$fileInfoDb = finfo_open(FILEINFO_MIME_TYPE);
                ErrorHandler::stop();
            }

            if (static::$fileInfoDb) {
                $type = finfo_buffer(static::$fileInfoDb, $buffer, FILEINFO_MIME_TYPE);
            }
        }

        return $type;
    }

    /**
     * @return string
     */
    public function getIdentifierName()
    {
        if (!$this->identifierName) {
            $this->identifierName = self::DEFAULT_IDENTIFIER_NAME;
        }
        return $this->identifierName;
    }

    /**
     * @param string $identifier
     * @return $this
     */
    public function setIdentifierName($identifier)
    {
        $this->identifierName = (string) $identifier;
        return $this;
    }
}
