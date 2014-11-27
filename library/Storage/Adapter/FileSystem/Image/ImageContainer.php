<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\FileSystem\Image;

use ImgMan\Storage\Image\AbstractStorageContainer;

/**
 * Class ImageContainer
 * @package ImgMan\Storage\Adapter\FileSystem\Image
 */
class ImageContainer extends AbstractStorageContainer
{
    /**
     * @var string
     */
    protected $pathFile;

    /**
     * Ctor
     * @param $pathFile
     */
    public function __construct($pathFile)
    {
        $this->pathFile = $pathFile;
    }

    /**
     * @return string
     */
    public function getPathFile()
    {
        return $this->pathFile;
    }
}
