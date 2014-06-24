<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 12.33
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Operation\Helper\Options\FormatOptionTrait;
use ImgManLibrary\Operation\Helper\Options\HeightWidthAllowupBackgroundOptionTrait;

class Format extends AbstractHelper
{
    use FormatOptionTrait;

    /**
     * @param $format
     * @return mixed
     */
    public function __invoke($format)
    {
        return $this->getAdapter()->format($format);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getFormat());
    }
}