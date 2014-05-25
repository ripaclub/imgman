<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 21/05/14
 * Time: 16.39
 */

namespace ImgManLibrary\Core\Adapter;

use ImgManLibrary\BlobInterface;

interface AdapterInterface
{
    /**
     * @param BlobInterface $image
     * @return int
     */
    public function getHeight();

    /**
     * @param BlobInterface $image
     * @return int
     */
    public function getWidth();

    /**
     * @param BlobInterface $image
     * @param $width
     * @param $height
     * @return bool
     */
    public function resize($width, $height);

    /**
     * @param BlobInterface $image
     * @param $x
     * @param $y
     * @param $with
     * @param $height
     * @return bool
     */
    public function crop($x, $y, $with, $height);

    /**
     * @param BlobInterface $image
     * @param $degrees
     * @param null $backgroundColor
     * @return bool
     */
    public function rotate($degrees, $backgroundColor = null);
} 