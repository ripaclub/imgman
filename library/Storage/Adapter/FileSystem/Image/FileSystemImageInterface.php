<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\FileSystem\Image;

use ImgMan\Image\ImageInterface;

/**
 * Interface FileSystemInterface
 *
 *
 * @package ImgMan\Storage\Adapter\FileSystem\Image
 */
interface FileSystemImageInterface extends ImageInterface
{
    /**
     * @param string $mime_type
     */
    public function setPath($path);

    /**
     * @return string|null
     */
    public function getPath();

} 