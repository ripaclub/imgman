<?php

namespace ImgManLibrary\Core\Adapter;

use ImgManLibrary\BlobAwareInterface;
use ImgManLibrary\BlobInterface;
use ImgManLibrary\Core\Blob\Blob;
use ImgManLibrary\Core\CoreInterface;
use Imagick;
use ImagickPixel;

class ImagickAdapter implements CoreInterface
{
    /**
     * @var Imagick
     */
    protected $adapter;

    /**
     * @param BlobInterface $image
     * @throws Exception\ModuleException
     */
    function __construct(BlobInterface $image = null)
    {

        if(!extension_loaded('imagick')) {
            throw new Exception\ModuleException('Module imagick not loaded');
        }

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
     * @throws Exception\ImageException
     */
    public function setBlob(BlobInterface $blob)
    {
        try {
            $result = $this->getAdapter()->readimageblob($blob->getBlob());
        }
        catch (\Exception $e) {
            throw new Exception\ImageException('Error to load image');
        }

        if ($result === false) {
            throw new Exception\ImageException('Error to load image');
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
            return 0;
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
     * @param $width
     * @param $height
     * @return bool
     */
    public function resize($width, $height)
    {
        try {
            return $this->getAdapter()->thumbnailImage($width, $height,  false, false);

        } catch (\ImagickException $e) {
            return false;

        }
    }

    /**
     * @param $format
     * @return bool|mixed
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
            $compression      = $this->getAdapter()->setcompressionquality($compression);
            $compressionImage = $this->getAdapter()->setimagecompressionquality($compressionQuality);
            return ($compression && $compressionImage);

        } catch (\ImagickException $e) {
            return false;

        }
    }

    /**
     * @param $x
     * @param $y
     * @param $width
     * @param $height
     * @return bool|mixed
     */
    public function crop($x, $y, $width, $height)
    {
        try {
            return $this->getAdapter()->cropimage($x, $y, $width, $height);

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
     * @return mixed
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
    public function create($width, $height, $backgroundColor = null, $format = null)
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
     * @param $x
     * @param $y
     * @param Blob $imageOver
     * @return bool
     */
    public function compose(Blob $imageUnder, $x, $y, Blob $imageOver = null)
    {
        if($imageOver == null) {
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
                $x,
                $y
        );
    }


} 