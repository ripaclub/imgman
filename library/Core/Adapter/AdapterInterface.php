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
     * @return mixed
     */
    public function getHeight();

    /**
     * @return mixed
     */
    public function getWidth();

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
    public function crop($x, $y, $with, $height);

    /**
     * @param $degrees
     * @param null $backgroundColor
     * @return mixed
     */
    public function rotate($degrees, $backgroundColor = null);

    /**
     * @return float
     */
    public function getRatio();
} 