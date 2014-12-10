<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Service;

use ImgMan\BlobInterface;
use ImgMan\Core\CoreAwareInterface;
use ImgMan\Core\CoreInterface;
use ImgMan\Operation\PluginManagerAwareInterface;
use ImgMan\Storage\StorageAwareInterface;
use ImgMan\Storage\StorageInterface;

use Zend\ServiceManager\AbstractPluginManager;

interface ServiceInterface extends StorageAwareInterface, CoreAwareInterface, PluginManagerAwareInterface
{
    /**
     * @return array
     */
    public function getRenditions();

    /**
     * @param array $renditions
     * @return ServiceInterface
     */
    public function setRenditions(array $renditions);

    /**
     * @param BlobInterface $blob
     * @param $identifier
     * @return string|null
     */
    public function grab(BlobInterface $blob, $identifier);

    /**
     * @param $identifier
     * @param string $rendition
     * @return ImgMan\Storage\Image\AbstractImageContainer|null
     */
    public function get($identifier, $rendition = CoreInterface::RENDITION_ORIGINAL);

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @param string $rendition
     * @return bool
     */
    public function save($identifier, BlobInterface $blob, $rendition = CoreInterface::RENDITION_ORIGINAL);

    /**
     * @param $identifier
     * @param BlobInterface $blob
     * @param string $rendition
     * @return bool
     */
    public function update($identifier, BlobInterface $blob, $rendition = CoreInterface::RENDITION_ORIGINAL);

    /**
     * @param $identifier
     * @param string $rendition
     * @return bool
     */
    public function delete($identifier, $rendition = CoreInterface::RENDITION_ORIGINAL);
}
