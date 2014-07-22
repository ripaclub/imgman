<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 21/05/14
 * Time: 16.39
 */

namespace ImgManLibrary\Core;

use ImgManLibrary\BlobAwareInterface;
use ImgManLibrary\Core\Blob\Blob;

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
     * @return mixed
     */
    public function getMimeType();

    /**
     * @param $width
     * @param $height
     * @return mixed
     */
    public function resize($width, $height);

    /**
     * @param $x
     * @param $y
     * @param $width
     * @param $height
     * @return bool|mixed
     */
    public function crop($x, $y, $width, $height);

    /**
     * @param $degrees
     * @param null $backgroundColor
     * @return mixed
     */
    public function rotate($degrees, $backgroundColor = null);

    /**
     * @param $format
     * @return mixed
     */
    public function format($format);

    /**
     * @return mixed
     */
    public function clear();

    /**
     * @param $width
     * @param $height
     * @param string $backgroundColor
     * @param null $format
     * @return Blob
     */
    public function create($width, $height, $backgroundColor =  'white', $format = null);

    /**
     * @param Blob $imageUnder
     * @param $x
     * @param $y
     * @param Blob $imageOver
     * @return bool
     */
    public function compose(Blob $imageUnder, $x, $y, Blob $imageOver = null);


}