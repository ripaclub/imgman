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
 * Interface S3ServiceInterface
 */
interface S3ServiceInterface
{
    /**
     * @param string $name
     * @param string $data
     * @return mixed
     */
    public function saveFile($name, $data);

    /**
     * @param string $name
     */
    public function deleteFile($name);
}