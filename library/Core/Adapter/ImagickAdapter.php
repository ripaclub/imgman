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
            $result =$this->getAdapter()->readimageblob($blob->getBlob());
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
     * @return null|string
     */
    public function getFormat()
    {
        try {
            return $this->adapter->getformat();

        } catch (\ImagickException $e) {
            return null;
        }
    }

    /**
     * @param $format
     * @return ImagickAdapter
     */
    public function setFormat($format)
    {
        try {
            $this->getAdapter()->setformat($format);
            return $this;

        } catch (\ImagickException $e) {
            return $this;
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

    public function format($format)
    {
        try {
            return $this->getAdapter()->setimageformat($format);

        } catch (\ImagickException $e) {
            return false;

        }
    }

    /**
     * @param $x
     * @param $y
     * @param $with
     * @param $height
     * @return bool
     */
    public function crop($x, $y, $with, $height)
    {
        try {
            return $this->getAdapter()->cropimage($x, $y, $with, $height);

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
     * return CoreInterface
     */
    protected function getAdapterFormat($format)
    {
        $imagick = new Imagick();
        $imagick->newImage($this->getWidth(), $this->getHeight(), "white");
        $imagick->compositeimage($this->getAdapter(), Imagick::COMPOSITE_OVER, 0, 0);
        $imagick->setImageFormat($format);

        $adapter =  new ImagickAdapter();

        return $adapter->setAdapter($imagick);
    }

} 