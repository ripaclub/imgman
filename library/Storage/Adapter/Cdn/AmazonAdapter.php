<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn;

use ImgMan\Storage\Adapter\Cdn\Amazon\S3\S3ServiceInterface;
use ImgMan\Storage\StorageInterface;
use ImgMan\BlobInterface;

/**
 * Class AmazonAdapter
 */
class AmazonAdapter implements StorageInterface
{

    /**
     * @var S3ServiceInterface
     */
    protected $s3Client;

    /**
     * AmazonAdapter constructor.
     * @param S3ServiceInterface $s3Client
     */
    public function __construct(S3ServiceInterface $s3Client)
    {
        $this->s3Client = $s3Client;
    }

    public function saveImage($identifier, BlobInterface $blob)
    {
       $this->s3Client->saveFile($identifier, $blob->getBlob());
    }

    public function updateImage($identifier, BlobInterface $blob)
    {
        $this->s3Client->saveFile($identifier, $blob->getBlob());
    }

    public function deleteImage($identifier)
    {
        $this->s3Client->deleteFile($identifier);
    }

    public function getImage($identifier)
    {
        new \Exception('TODO ' .  __CLASS__);
        // TODO: Implement getImage() method.
    }

    public function hasImage($identifier)
    {
        new \Exception('TODO ' .  __CLASS__);
        // TODO: Implement hasImage() method.
    }


}