<?php

namespace ImgManLibrary;

interface BlobInterface
{
    /**
     * @return string
     */
    public function getBlob();

    /**
     * @param string $blob
     * @return BlobInterface
     */
    public function setBlob($blob);
} 