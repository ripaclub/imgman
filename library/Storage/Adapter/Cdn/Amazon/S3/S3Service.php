<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn\Amazon\S3;

use Aws\S3\S3Client;

/**
 * Class S3Service
 */
class S3Service implements S3ServiceInterface
{
    /**
     * @var S3Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $bucket;

    /**
     * @var string
     */
    protected $path;

    /**
     * S3Service constructor.
     * @param $client
     */
    public function __construct(S3Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $name
     * @param string $data
     * @return mixed
     */
    public function saveFile($name, $data)
    {
        $command = $this->client->getCommand(
            'PutObject',
            [
                'Bucket' => $this->getBucket(),
                'Key'    => $name,
                'Body'   => $data,
                'ACL'    => 'public-read',
            ]
        );
        return $this->client->execute($command);
    }

    /**
     * @param string $name
     * @return \Aws\Result
     */
    public function deleteFile($name)
    {
        return $this->client->deleteObject([
            // Bucket is required
            'Bucket' => $this->getBucket(),
            'Key'    => $name
        ]);
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     * @return $this
     */
    public function setClient(S3Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * @param string $bucket
     * @return $this
     */
    public function setBucket($bucket)
    {
        $this->bucket = $bucket;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
}