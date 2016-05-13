<?php
/**
 * Created by PhpStorm.
 * User: visa
 * Date: 13/05/16
 * Time: 16.21
 */

namespace ImgMan\Image;


interface SrcAwareInterface
{
    /**
     * @return string|null
     */
    public function getSrc();

    /**
     * @param $src string
     * @return $this
     */
    public function setSrc($src);
}