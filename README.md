Image manager
=============

[![Latest Stable Version](https://poser.pugx.org/ripaclub/imgman/v/stable.png)](https://packagist.org/packages/ripaclub/imgman) [![Build Status](https://travis-ci.org/ripaclub/imgman.png?branch=master)](https://travis-ci.org/ripaclub/imgman) [![Coverage Status](https://coveralls.io/repos/ripaclub/imgman/badge.png?branch=master)](https://coveralls.io/r/ripaclub/imgman) [![Dependency Status](https://www.versioneye.com/user/projects/5433f990ee3a885992000069/badge.svg)](https://www.versioneye.com/user/projects/5433f990ee3a885992000069)

ImgMan is a library that allows you to create various image renditions from any [PHP supported URL-style protocol](http://php.net/manual/en/wrappers.php) containing a picture.

You can modify an image (e.g., resize, crop, format, fit in, fit out, rotate) and save different renditions stored in your configuration.

Requisites
----------

* PHP >= 5.4

* Composer

* Imagick (the only adapter currently supported to manipulate image)

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

  A set of classes aimed at the instantiation of ImgMan service. With this service you can save the image in all renditions configured in the service (`grab` function)
  You can also save  update, and delete an image in a specific redition

Installation
------------

Install `ImageImagick` (version > 3.1.2) in php extension.

Add `ripaclub/imgman` to your `composer.json`.

```
{
   "require": {
       "ripaclub/imgman": "0.3.*"
   }
}
```

Configuration
-------------

Configure service manager with service factory (for storage and service), plugin manager and imagick adapter.

```php
return [
    \\ ...
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
    \\ ...
];
```

Configure storage (e.g Mongo) where to save the images:

```php
return [
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
    \\ ...
 ];
```

Configure ImgMan service with the storage, helper, adapter and the various operations to attach on the renditions:

```php
return [
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
                        'height' => 200,
                    ],
                    'compression' => [
                        'compression' => 90,
                        'compressionQuality' => 70,
                    ]
                ],
                'thumbmaxi' => [
                    'resize' => [
                        'width'  => 400,
                        'height' => 400,
                    ],
                ],
            ],
        ],
    ],
    \\ ...
 ];
```

Usage
-----

Now we get the IgmMan service, load a picture from file stream (filesystem) and save it in 3 renditions (original, thumb, and thumbmaxi).

```php
$imgMan = $this->getServiceLocator()->get('ImgMan\Service\First');
$image = new ImgMan\Image\ImageContainer(__DIR__. '/../../../name_image.png'); //the path can be also a URL
$imgMan->grab($image, '/first/name/identifier/');
```

Finally, we can recover the image rendition we desire this way:

```php
$imageOriginal = $imgMan->get('/first/name/identifier/', 'original');
$imageThumb = $imgMan->get('/first/name/identifier/', 'thumb');
$imageThumbMaxi = $imgMan->get('/first/name/identifier/', 'thumbmaxi');
```

---

[![Analytics](https://ga-beacon.appspot.com/UA-49655829-1/ripaclub/imgman)](https://github.com/igrigorik/ga-beacon)
