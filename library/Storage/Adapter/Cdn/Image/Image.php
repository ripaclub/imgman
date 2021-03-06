<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Cdn\Image;

use ImgMan\Image\Image as BaseImage;
use ImgMan\Image\SrcAwareInterface;
use ImgMan\Image\SrcAwareTrait;

class Image extends BaseImage implements SrcAwareInterface
{
    use SrcAwareTrait;
}