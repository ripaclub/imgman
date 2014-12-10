<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Core\Adapter;

use ImgMan\BlobInterface;
use ImgMan\Core\Blob\Blob;
use ImgMan\Core\CoreInterface;
use Imagick;
use ImagickPixel;
use ImgMan\Core\Exception\ImageException;

/**
 * Class ImagickAdapter
 */
class ImagickAdapter implements CoreInterface
{
    /**
     * @var Imagick
     */
    protected $adapter;

    /**
     * @param BlobInterface $image
     */
    public function __construct(BlobInterface $image = null)
    {
        $this->setAdapter(new Imagick());
        if ($image) {
            $this->setBlob($image);
        }
    }

    /**
     * @param Imagick $adapter
     */
    public function setAdapter(Imagick $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return Imagick
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @return BlobInterface
     */
    public function getBlob()
    {
        $wrapper = new Blob();
        return $wrapper->setBlob($this->getAdapter()->getimageblob());
    }

    /**
     * @param BlobInterface $blob
     * @return ImagickAdapter
     * @throws ImageException
     */
    public function setBlob(BlobInterface $blob)
    {
        try {
            $result = $this->getAdapter()->readimageblob($blob->getBlob());
        } catch (\Exception $e) {
            throw new ImageException('Error loading image', null, $e);
        }

        if ($result === false) {
            throw new ImageException('Error loading image');
        }

        return $this;
    }

    /**
     * @param null $color
     * @return ImagickPixel
     */
    protected function getImagePixel($color = null)
    {
        return new ImagickPixel($color ? $color : 'white');
    }

    /**
     * @return string|null
     */
    public function getMimeType()
    {
        try {
            $information = $this->getAdapter()->identifyimage();
            return $information['mimetype'];
        } catch (\ImagickException $e) {
            return null;
        }
    }

    /**
     * @return float
     */
    public function getRatio()
    {
        try {
            return $this->getWidth() / $this->getHeight();

        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        try {

            return $this->getAdapter()->getimageheight();

        } catch (\ImagickException $e) {
            return (float) 0;
        }
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        try {
            return $this->getAdapter()->getimagewidth();

        } catch (\ImagickException $e) {
            return 0;
        }
    }

    /**
     * @return null|string
     */
    public function getFormat()
    {
        try {
            return $this->getAdapter()->getimageformat();
        } catch (\ImagickException $e) {
            return null;
        }
    }

    /**
     * @param $width
     * @param $height
     * @return bool
     */
    public function resize($width, $height)
    {
        try {
            return $this->getAdapter()->thumbnailImage($width, $height, false, false);

        } catch (\ImagickException $e) {
            return false;

        }
    }

    /**
     * @param $format
     * @return bool|string
     */
    public function format($format)
    {
        return $this->getAdapter()->setimageformat($format);
    }

    /**
     * @param $compression
     * @param $compressionQuality
     * @return bool
     */
    public function compression($compression, $compressionQuality)
    {
        try {
            $compression = $this->getAdapter()->setcompressionquality($compression);
            $compressionImage = $this->getAdapter()->setimagecompressionquality($compressionQuality);
            return ($compression && $compressionImage);

        } catch (\ImagickException $e) {
            return false;

        }
    }

    /**
     * {@inheritdoc}
     */
    public function crop($cordX, $cordY, $width, $height)
    {
        try {
            return $this->getAdapter()->cropimage($cordX, $cordY, $width, $height);

        } catch (\ImagickException $e) {
            return false;
        }
    }

    /**
     * @param $degrees
     * @param null $backgroundColor
     * @return bool
     */
    public function rotate($degrees, $backgroundColor = null)
    {
        try {
            return $this->getAdapter()->rotateimage(
                $this->getImagePixel($backgroundColor),
                $degrees
            );

        } catch (\ImagickException $e) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function clear()
    {
        return $this->getAdapter()->clear();
    }

    /**
     * @param $width
     * @param $height
     * @param null $backgroundColor
     * @param null $format
     * @return Blob
     */
    public function create($width, $height, $format, $backgroundColor = null)
    {
        $adapter = new Imagick();
        $adapter->newimage(
            $width,
            $height,
            $this->getImagePixel($backgroundColor),
            $format
        );

        $wrapper = new Blob();
        return $wrapper->setBlob($adapter->getimageblob());
    }

    /**
     * @param Blob $imageUnder
     * @param int $cordX
     * @param int $cordY
     * @param Blob $imageOver
     * @return bool
     */
    public function compose(Blob $imageUnder, $cordX, $cordY, Blob $imageOver = null)
    {
        if ($imageOver == null) {
            $adapter = clone $this->getAdapter();

        } else {
            $selfAdapter = new ImagickAdapter($imageOver);
            $adapter = $selfAdapter->getAdapter();
        }

        return $this->setBlob($imageUnder)
             ->getAdapter()
             ->compositeimage(
                 $adapter,
                 Imagick::COMPOSITE_OVER,
                 $cordX,
                 $cordY
             );
    }
}
