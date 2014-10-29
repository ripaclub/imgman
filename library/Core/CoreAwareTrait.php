<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Core;

/**
 * Trait CoreAwareTrait
 */
trait CoreAwareTrait
{
    /**
     * @var CoreInterface
     */
    protected $adapter = null;

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
}
