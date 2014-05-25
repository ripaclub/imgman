<?php

namespace ImgManLibrary\Core\Adapter;

use ImgManLibrary\BlobAwareInterface;
use ImgManLibrary\BlobInterface;
use ImgManLibrary\Core\ImageContenitor;
use Imagick;
use ImagickPixel;

class ImagickAdapter implements AdapterInterface, BlobAwareInterface
{
    /**
     * @var Imagick
     */
    protected $adapter;

    /**
     * @param BlobInterface $image
     * @throws Exception\ModuleException
     */
    function __construct(BlobInterface $image)
    {
        if(!extension_loaded('imagick')) {
            throw new Exception\ModuleException('Module imagick not loaded');
        }

        $this->setAdapter(new Imagick());
        $this->setBlob($image);
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
        $contenitor = new ImageContenitor();
        return $contenitor->setBlob($this->getAdapter()->getimageblob());
    }

    /**
     * @param BlobInterface $blob
     * @return ImagickAdapter
     */
    public function setBlob(BlobInterface $blob)
    {
        try {
            $result =$this->getAdapter()->pingImageBlob($blob->getBlob());
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

    public function getMimeTypeLoaded()
    {
        try {
            $information = $this->getAdapter()->identifyimage();

        } catch (\ImagickException $e) {
            return null;
        }
    }

    /**
     * @param BlobInterface $image
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
     * @param BlobInterface $image
     * @param $format
     * @return AdapterInterface
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
     * @param BlobInterface $image
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
     * @param BlobInterface $image
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
     * @param BlobInterface $image
     * @param $width
     * @param $height
     * @return bool
     */
    public function resize($width, $height)
    {
        try {
            return $this->getAdapter()->resizeimage($width, $height, \Imagick::FILTER_LANCZOS, 1, false);

        } catch (\ImagickException $e) {
            return false;
        }
    }

    /**
     * @param BlobInterface $image
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
     * @param BlobInterface $image
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

    /*
        public function convert(BlobInterface $image = null, $format)
        {
            if ($image) {
                $this->loadImage($image);
            }

            if ($format != $this->getFormat($image)) {

                $imagick = $this->getImagick($image);

                $newImagick = new \Imagick();
                $newImagick->newimage(
                    $imagick->getimagewidth(),
                    $imagick->getimageheight(),
                    $this->getImagickPixel(),
                    $format
                );

                $newImagick->compositeimage($imagick, \Imagick::COMPOSITE_OVER, 0, 0);

                $imagick->destroy();
                $image->getBackendContainer()->imagick = $newImagick;
            }
        }
    */
} 