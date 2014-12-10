<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Service;

use ImgMan\Core\CoreInterface;
use ImgMan\Storage\StorageInterface;
use Zend\ServiceManager\AbstractPluginManager;

/**
 * Class Service
 */
class Service extends AbstractService
{
    /**
     * @param StorageInterface $storage
     * @param AbstractPluginManager $pluginManager
     * @param CoreInterface $imageAdapter
     */
    public function __construct(
        StorageInterface $storage = null,
        AbstractPluginManager $pluginManager = null,
        CoreInterface $imageAdapter = null
    ) {
        if ($storage) {
            $this->setStorage($storage);
        }

        if ($pluginManager) {
            $this->setPluginManager($pluginManager);
        }

        if ($imageAdapter) {
            $this->setAdapter($imageAdapter);
        }
        // Set default regex
        $pchar = '(?:[' . self::CHAR_UNRESERVED . ':@&=\+\$,]+|%[A-Fa-f0-9]{2})*';
        $segment = $pchar . "(?:;{$pchar})*";
        $regex = "/^{$segment}(?:\/{$segment})*$/";
        $this->setRegExIdentifier($regex);
    }
}
