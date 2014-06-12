<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 31/05/14
 * Time: 15.00
 */

namespace ImgManLibrary\Operation\Helper\Operation;


use Zend\Stdlib\AbstractOptions;

trait CompressionOptionTrait
{
    use AbstractOptionTrait;

    /**
     * @var int
     */
    protected $compression;

    /**
     * @var int (1 - 100)
     */
    protected $compressionQuality;

    /**
     * @param int $compression
     */
    public function setCompression($compression)
    {
        $this->compression = $compression;
    }

    /**
     * @return int
     */
    public function getCompression()
    {
        return $this->compression;
    }

    /**
     * @param int $compressionQuality
     */
    public function setCompressionQuality($compressionQuality)
    {
        $this->compressionQuality = $compressionQuality;
    }

    /**
     * @return int
     */
    public function getCompressionQuality()
    {
        return $this->compressionQuality;
    }


}