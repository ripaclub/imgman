Image manager [![Build Status](https://travis-ci.org/ripaclub/imgman.png?branch=master)](https://travis-ci.org/ripaclub/imgman)&nbsp;[![Latest Stable Version](https://poser.pugx.org/ripaclub/imgman/v/stable.png)](https://packagist.org/packages/ripaclub/imgman)&nbsp;
=============

Image Manager is a library that allows you to create various image renditions from a picture.

You can modify an image (e.g., resize, crop, format, fit in, fit out, rotate) and save different renditions stored in your configuration.

Requisites
----------

* PHP >= 5.4

* Composer

* Imagick (Only adapter to manipulate image)

Features
--------

ImgMan has various features:

* Core

    contains the engine that execute the operations on the image. `ImageMagick` is the only adapter present.
   
* Operation

    Contains a class, `HelperPluginManager`, that is a `AbstractPluginManager` where are config all operation that can attach to a rendition (i.e. `Compression`, `Crop`, `FitIn`, `FitOut`, `Format`, `Resize`, `Rotate`,`ScaleToHeight`,`ScaleToWidth`)

* Storage

    ImgMan allows you to save the image in several layers persistence, via `StorageInterface` objects (i.e. `FileSystem`, `Mongo`)

* Image
    
    Contains the class used to the image

* Service

  A set of classes aimed at the instantiation of ImgMan service. With this service you can save the image in all renditions configured in the service (`grub` function)
  You can also save  update, and delete an image in a specific redition

Installation
------------

Install `ImageImagick` (version > 3.1.2) in php extension.

Add `ripaclub/imgman` to your `composer.json`.

```
{
   "require": {
       "ripaclub/imgman": "v0.2.0"
   }
}
```

Configuration
-------------

Configure service manager with service factory (for storage and service), plugin manager and imagick adapter.

```php
$serviceManager = new ServiceManager\ServiceManager(
    new ServiceManagerConfig([
            'abstract_factories' => [
                 // Load abstract service
                'ImgMan\Service\ServiceFactory',
                 // Load abstract factory to mongo connection
                'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
                 // Load abstract factory to mongo adapter
                'ImgMan\Storage\Adapter\Mongo\MongoAdapterAbstractServiceFactory',
                 // Load abstract factory to FileSystem adapter
                'ImgMan\Storage\Adapter\FileSystem\FileSystemAbstractServiceFactory'
            ],
            'factories' => [
                 // Load (operation) helper plugin manager
                'ImgMan\Operation\HelperPluginManager' => 'ImgMan\Operation\HelperPluginManagerFactory',
            ],
            'invokables' => [
                 // Load adapter
                'ImgMan\Adapter\Imagick' => 'ImgMan\Core\Adapter\ImagickAdapter',
            ],
        ]
    )
);
```

Config storage to save the image (e.g Mongo):

```php
$config = [
    \\ ...
    'imgman_mongodb' => [
        'MongoDb' => [
            'database' => 'imgManStorage'
        ]
    ],
    'imgman_adapter_mongo' => [
        'ImgMan\Storage\Mongo' => [
            'collection' => 'image_test',
            'database' => 'MongoDb'
        ]
    ],
 ];
```

Config imgman service with the storage, helper, adapter and the various operation to attach on the renditions

```php
$config = [
    \\ ...
    'imgman_services' => [
        'ImgMan\Service\First' => [
            'adapter' => 'ImgMan\Adapter\Imagick',
            'storage' => 'ImgMan\Storage\Mongo',
            'helper_manager' => 'ImgMan\Operation\HelperPluginManager',
            'renditions' => [
                'thumb' => [
                    'resize' => [
                        'width'  => 200,
                        'height' => 200
                    ],
                    'compression' => [
                        'compression' => 90
                        'compressionQuality' => 70
                     ]
                ],
                'thumbmaxi' => [
                    'resize' => [
                        'width'  => 400,
                        'height' => 400
                    ]
                ]
            ]
        ]
    ]
 ];
```

Usage
-----

```php
$serviceManager = $this->getServiceLocator()->get('ImgMan\Service\Test');
$image = new ImageContainer(__DIR__. '/../../../name_image.png');
// The service save the image in 3 rendition (normal, thumb and thumbmaxi
$serviceImgMan->grab($image, 'test/name/identifier');
$image = $serviceImgMan->get('test/name/identifier', 'thumb');
```



[![Analytics](https://ga-beacon.appspot.com/UA-49655829-1/ripaclub/imgman)](https://github.com/igrigorik/ga-beacon)