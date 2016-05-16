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
use Zend\Http\Client;
use Zend\Http\Request;

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
     * @var string
     */
    protected $origin;

    /**
     * @var string
     */
    protected $scheme = 'https';

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
        $request->setUri( $this->scheme . '://' . $this->domain . '/' . $path);
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
        $request->setMethod(Request::METHOD_HEAD);
        $headers = $request->getHeaders();
        $headers->addHeaderLine('Origin', $this->getOrigin());
        $headers->addHeaderLine('Access-Control-Request-Method', 'GET');
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

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     * @return $this
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     * @return $this
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
        return $this;
    }
}