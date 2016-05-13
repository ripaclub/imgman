<?php
/**
 * Created by PhpStorm.
 * User: visa
 * Date: 13/05/16
 * Time: 16.21
 */

namespace ImgMan\Image;

/**
 * Class SrcAwareTrait
 */
trait SrcAwareTrait
{
    /**
     * @var string|null
     */
    protected $src;

    /**
     * @return null|string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param string $src
     * @return $this
     */
    public function setSrc($src)
    {
        $this->src = $src;
        return $this;
    }


}