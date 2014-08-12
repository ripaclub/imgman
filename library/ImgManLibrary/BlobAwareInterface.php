<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 26/05/14
 * Time: 0.45
 */

namespace ImgManLibrary;

interface BlobAwareInterface
{
    /**
     * @return BlobInterface
     */
    public function getBlob();

    /**
     * @param BlobInterface $blob
     */
    public function setBlob(BlobInterface $blob);
} 