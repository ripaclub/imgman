<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 21/05/14
 * Time: 16.39
 */

namespace ImgManLibrary\Core;

use ImgManLibrary\BlobAwareInterface;
use ImgManLibrary\BlobInterface;

interface CoreInterface extends BlobAwareInterface
{
    const MIME_TYPE_PNG  = "image/png";
    const MIME_TYPE_JPEG = "image/jpeg";
    const MIME_TYPE_GIF  = "image/gif";

    const RENDITION_ORIGINAL = 'original';

    /**
     * @return mixed
     */
    public function getHeight();

    /**
     * @return mixed
     */
    public function getWidth();

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
     * @param $with
     * @param $height
     * @return mixed
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
     * @return float
     */
    public function getRatio();
}