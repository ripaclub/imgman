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

/**
 * Class CloudFrontServiceInterface
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

    public function getFile($name)
    {
        // TODO: Implement getFile() method.
    }

    public function hasFile($name)
    {
        // TODO: Implement hasFile() method.
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