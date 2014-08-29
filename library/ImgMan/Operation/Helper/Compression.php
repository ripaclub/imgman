<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper;

use ImgMan\Operation\Helper\Options\CompressionOptionTrait;

class Compression extends AbstractHelper
{
    use CompressionOptionTrait;

    /**
     * @param int $compression
     * @param int $compressionQuality
     */
    public function __invoke($compression, $compressionQuality)
    {
        return $this->getAdapter()->compression($compression, $compressionQuality);
    }

    /**
     * @param array $params
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getCompression(), $this->getCompressionQuality());
    }
}