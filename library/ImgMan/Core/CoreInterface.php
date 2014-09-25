<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Core;

use ImgMan\BlobAwareInterface;
use ImgMan\Core\Blob\Blob;

/**
 * Interface CoreInterface
 */
interface CoreInterface extends BlobAwareInterface
{
    const MIME_TYPE_PNG  = "image/png";
    const MIME_TYPE_JPEG = "image/jpeg";
    const MIME_TYPE_GIF  = "image/gif";

    const RENDITION_ORIGINAL = 'original';

    /**
     * @return int
     */
    public function getHeight();

    /**
     * @return int
     */
    public function getWidth();

    /**
     * @return float
     */
    public function getRatio();

    /**
     * @return  null|string
     */
    public function getFormat();

    /**
     * @return null|string
     */
    public function getMimeType();

    /**
     * @param $width
     * @param $height
     * @return bool
     */
    public function resize($width, $height);

    /**
     * @param $cordX
     * @param $cordY
     * @param $width
     * @param $height
     * @return bool
     */
    public function crop($cordX, $cordY, $width, $height);

    /**
     * @param $degrees
     * @param null $backgroundColor
     * @return bool
     */
    public function rotate($degrees, $backgroundColor = null);

    /**
     * @param $format
     * @return bool
     */
    public function format($format);

    /**
     * @param $width
     * @param $height
     * @param $format
     * @param null $backgroundColor
     * @return Blob
     */
    public function create($width, $height, $format, $backgroundColor = null);

    /**
     * @return bool
     */
    public function clear();

    /**
     * @param Blob $imageUnder
     * @param $cordX
     * @param $cordY
     * @param Blob $imageOver
     * @return bool
     */
    public function compose(Blob $imageUnder, $cordX, $cordY, Blob $imageOver = null);
}
