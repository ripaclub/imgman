<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 30/05/14
 * Time: 18.06
 */

namespace ImgManLibrary\Storage;


use ImgManLibrary\Operation\PluginManagerAwareTrait;

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