<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage;

interface StorageAwareInterface
{

    /**
     * @return StorageInterface
     */
    public function getStorage();

    /**
     * @param StorageInterface $storage
     * @return mixed
     */
    public function setStorage(StorageInterface $storage);
}
