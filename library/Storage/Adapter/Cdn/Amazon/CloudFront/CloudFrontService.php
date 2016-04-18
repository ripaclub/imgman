<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn\Amazon\CloudFront;

use Aws\CloudFront\CloudFrontClient;
use Zend\Http\Request;
use Zend\Http\Client;

/**
 * Class CloudFrontService
 */
class CloudFrontService implements CloudFrontServiceInterface
{
    /**
     * @var CloudFrontClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $domain;

    /**
     * CloudFrontService constructor.
     * @param CloudFrontClient $client
     */
    public function __construct(CloudFrontClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param $path
     * @return Request
     */
    protected function createRequest($path)
    {
        $request = new Request();
        $request->setUri('http://' . $this->domain . '/' . $path);
        return $request;
    }

    /**
     * @param $name
     * @return Client
     */
    public function getFile($name)
    {
        $client = new Client();
        $request = $this->createRequest($name);
        $response = $client->send($request);

        if ($response->getStatusCode() == 200) {
            return $client;
        }

        throw  new \RuntimeException($response->getBody());
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasFile($name)
    {
        $client = new Client();
        $request = $this->createRequest($name);
        $response = $client->send($request);
        if ($response->getStatusCode() == 200) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     * @return $this
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }
}