<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter;

use Zend\Stdlib\ErrorHandler;

/**
 * Class DetectMimeTypeTrait
 */
trait DetectMimeTypeTrait
{
    /**
     * Fileinfo magic database resource
     *
     * This variable is populated the first time _detectFileMimeType is called
     * and is then reused on every call to this method
     *
     * @var resource
     */
    protected static $fileInfoDb = null;

    /**
     * @param $buffer
     * @return string|null
     */
    protected function detectBufferMimeType($buffer)
    {
        $type = null;
        if (function_exists('finfo_open')) {
            if (static::$fileInfoDb === null) {
                ErrorHandler::start();
                static::$fileInfoDb = finfo_open(FILEINFO_MIME_TYPE);
                ErrorHandler::stop();
            }

            if (static::$fileInfoDb) {
                $type = finfo_buffer(static::$fileInfoDb, $buffer, FILEINFO_MIME_TYPE);
            }
        }

        return $type;
    }
}