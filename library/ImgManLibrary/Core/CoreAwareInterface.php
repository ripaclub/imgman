<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 21/05/14
 * Time: 16.39
 */

namespace ImgManLibrary\Core;

use ImgManLibrary\BlobInterface;

interface CoreAwareInterface
{
    public function setAdapter(CoreInterface $adapter);

    /**
     * @return CoreInterface
     */
    public function getAdapter();
} 