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
use ImgMan\Image\ImageInterface;
use ImgMan\Operation\PluginManagerAwareInterface;
use ImgMan\Service\Exception\InvalidArgumentException;
use ImgMan\Storage\StorageAwareInterface;
use ImgMan\Storage\StorageInterface;
use Zend\ServiceManager\AbstractPluginManager;

interface ImageServiceInterface extends StorageAwareInterface, CoreAwareInterface, PluginManagerAwareInterface
{
    const ALL_RENDITION = '----ALL-RENDITION----';

    /**
     * @return array
     */
    public function getRenditions();

    /**
     * @param array $renditions
     * @return $this
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
     * @return ImageInterface|null
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

    /**
     * @param $regExIdentifier
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setRegExIdentifier($regExIdentifier);

    /**
     * @param AbstractPluginManager $pluginManager
     * @return $this
     */
    public function setPluginManager(AbstractPluginManager $pluginManager);

    /**
     * @param StorageInterface $storage
     * @return $this
     */
    public function setStorage(StorageInterface $storage);

    /**
     * @param CoreInterface $adapter
     * @return $this
     */
    public function setAdapter(CoreInterface $adapter);
}
