<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn;

use ImgMan\Storage\Adapter\Cdn\Image;
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
        // TODO  manage exception
        $this->s3Client->saveFile($identifier, $blob->getBlob());
    }

    public function updateImage($identifier, BlobInterface $blob)
    {
        $identifier = $this->getNameStrategy()->hydrate($identifier);
        return $this->s3Client->saveFile($identifier, $blob->getBlob());
    }

    public function deleteImage($identifier)
    {
        $identifier = $this->getNameStrategy()->hydrate($identifier);
        // TODO  manage exception
        $this->s3Client->deleteFile($identifier);
    }

    public function getImage($identifier)
    {
        $identifier = $this->getNameStrategy()->hydrate($identifier);
        try {
            $client = $this->cloudFrontClient->getFile($identifier);
            $response = $client->getResponse();
            $request = $client->getRequest();
            $image = new Image();
            $image->setBlob($response->getBody());
            $image->setSize(strlen($response->getBody()));
            $image->setMimeType($this->detectBufferMimeType($response->getBody()));
            $image->setSrc($request->getUri()->toString());
            return $image;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function hasImage($identifier)
    {
        $identifier = $this->getNameStrategy()->hydrate($identifier);
        return $this->cloudFrontClient->hasFile($identifier);
    }

    /**
     * @return NamingStrategyInterface
     */
    public function getNameStrategy()
    {
        if (!$this->nameStrategy) {
            throw  new \RuntimeException('nameStrategy must be set before');
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