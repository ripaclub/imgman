<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper;

use ImgMan\Operation\Helper\Options\FormatOptionTrait;

/**
 * Class Format
 */
class Format extends AbstractHelper
{
    use FormatOptionTrait;

    /**
     * @param $format
     * @return bool
     */
    public function __invoke($format)
    {
        return $this->getAdapter()->format($format);
    }

    /**
     * @param array $params
     * @return bool
     */
    public function execute(array $params)
    {
        $this->setFromArray($params);
        return $this->__invoke($this->getFormat());
    }
}
