<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Core;

use ImgMan\BlobInterface;

interface CoreAwareInterface
{
    /**
     * @param CoreInterface $adapter
     */
    public function setAdapter(CoreInterface $adapter);

    /**
     * @return CoreInterface
     */
    public function getAdapter();
} 