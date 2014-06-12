<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 12.33
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Operation\Helper\Operation\FormatOptionTrait;
use ImgManLibrary\Operation\Helper\Operation\HeightWidthAllowupBackgroundOptionTrait;

class Format extends AbstractHelper
{
    use FormatOptionTrait;

    /**
     * @param $format
     */
    public function __invoke($format)
    {
        $this->getAdapter()->format($format);
    }

    /**
     * @param array $params
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getFormat());
    }
}