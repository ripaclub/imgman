<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper\Options;

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
