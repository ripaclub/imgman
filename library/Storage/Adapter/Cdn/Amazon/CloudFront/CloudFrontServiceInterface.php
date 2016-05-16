<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn\Amazon\CloudFront;

use Zend\Http\Client;
use Zend\Uri\Uri;

/**
 * Interface CloudFrontServiceInterface
 */
interface CloudFrontServiceInterface
{
    /**
     * @param $name
     * @return Client
     */
    public function getFile($name);


    /**
     * @param $name
     * @return boolean
     */
    public function hasFile($name);

    /**
     * @param $path
     * @return Uri
     */
    public function createUri($path);
}