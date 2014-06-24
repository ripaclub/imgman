<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 12.33
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Operation\Helper\Options\CompressionOptionTrait;

class Compression extends AbstractHelper
{
    use CompressionOptionTrait;

    /**
     * @param $compression
     * @param $compressionQuality
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