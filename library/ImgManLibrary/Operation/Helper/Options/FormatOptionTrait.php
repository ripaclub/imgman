<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 31/05/14
 * Time: 15.00
 */

namespace ImgManLibrary\Operation\Helper\Options;

trait FormatOptionTrait
{
    use AbstractOptionTrait;

    protected $format;

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
}