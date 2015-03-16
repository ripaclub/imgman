<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\FileSystem\Image;

use ImgMan\Image\ImageTrait;


/**
 * Class Image
 *
 */
class Image implements FileSystemImageInterface
{
    use ImageTrait;
    use FileSystemImageTrait;
}
