<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper;

use ImgMan\Core\CoreInterface;

abstract class AbstractHelper implements HelperInterface
{
    const DEFAULT_FORMAT = 'jpeg';

    protected $adapter;
    /**
     * @param CoreInterface $adapter
     */
    public function setAdapter(CoreInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return CoreInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        $format = ($this->getAdapter()->getFormat() == null) ? self::DEFAULT_FORMAT : $this->getAdapter()->getFormat();
        return $format;
    }
} 