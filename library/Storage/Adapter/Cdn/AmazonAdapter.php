<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn;

use ImgMan\Storage\Adapter\Cdn\Amazon\CloudFront\CloudFrontServiceInterface;
use ImgMan\Storage\Adapter\Cdn\Amazon\S3\S3ServiceInterface;
use ImgMan\Storage\StorageInterface;
use ImgMan\BlobInterface;
use Zend\Stdlib\Hydrator\NamingStrategy\NamingStrategyInterface;

/**
 * Class AmazonAdapter
 */
class AmazonAdapter implements StorageInterface
{

    /**
     * @var NamingStrategyInterface
     */
    protected $nameStrategy;

    /**
     * @var S3ServiceInterface
     */
    protected $s3Client;

    /**
     * @var CloudFrontServiceInterface
     */
    protected $cloudFrontClient;

    /**
     * AmazonAdapter constructor.
     * @param S3ServiceInterface $s3Client
     * @param CloudFrontServiceInterface $cloudFrontClient
     */
    public function __construct(S3ServiceInterface $s3Client, CloudFrontServiceInterface $cloudFrontClient)
    {
        $this->s3Client = $s3Client;
        $this->cloudFrontClient = $cloudFrontClient;
    }

    public function saveImage($identifier, BlobInterface $blob)
    {
        $identifier = $this->getNameStrategy()->hydrate($identifier);
        $this->s3Client->saveFile($identifier, $blob->getBlob());
    }

    public function updateImage($identifier, BlobInterface $blob)
    {
        $identifier = $this->getNameStrategy()->hydrate($identifier);
        $this->s3Client->saveFile($identifier, $blob->getBlob());
    }

    public function deleteImage($identifier)
    {
        $identifier = $this->getNameStrategy()->hydrate($identifier);
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

    /**
     * @return NamingStrategyInterface
     */
    public function getNameStrategy()
    {
        if (!$this->nameStrategy) {
            throw  new \RuntimeException('nameStrategy must be set');
        }
        return $this->nameStrategy;
    }

    /**
     * @param NamingStrategyInterface $nameStrategy
     * @return $this
     */
    public function setNameStrategy(NamingStrategyInterface $nameStrategy)
    {
        $this->nameStrategy = $nameStrategy;
        return $this;
    }
}