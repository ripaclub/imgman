Image manager
=============

[![Latest Stable Version](https://img.shields.io/packagist/v/ripaclub/imgman.svg?style=flat-square)](https://packagist.org/packages/ripaclub/imgman) [![Build Status](https://img.shields.io/travis/ripaclub/imgman/master.svg?style=flat-square)](https://travis-ci.org/ripaclub/imgman) [![Coverage Status](https://img.shields.io/coveralls/ripaclub/imgman/master.svg?style=flat-square)](https://coveralls.io/r/ripaclub/imgman)

ImgMan is a library that allows you to create various image renditions from any [PHP supported URL-style protocol](http://php.net/manual/en/wrappers.php) containing a picture.

You can modify an image (e.g., resize, crop, format, fit in, fit out, rotate) and save different renditions stored in your configuration.

Requisites
----------

* PHP >= 5.5

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
       "ripaclub/imgman": "0.4.*"
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
        'ImgMan\Service\ImageServiceAbstractFactory',
         // Load abstract factory for mongo storage
        'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
        'ImgMan\Storage\Adapter\Mongo\MongoAdapterAbstractServiceFactory',
         // Load abstract factory to FileSystem storage
        'ImgMan\Storage\Adapter\FileSystem\FileSystemAbstractServiceFactory'
          // Load abstract factory to aws storage previus import of aws/aws-sdk-php 3.17.6
        'ImgMan\Storage\Adapter\Cdn\Amazon\S3\S3ServiceAbstractFactory',
        'ImgMan\Storage\Adapter\Cdn\Amazon\CloudFront\CloudFrontServiceAbstractFactory',
        'ImgMan\Storage\Adapter\Cdn\AmazonAdapterAbstractFactory',
    ],
    'factories' => [
         // Load (operation) helper plugin manager
        'ImgMan\Operation\HelperPluginManager' => 'ImgMan\Operation\HelperPluginManagerFactory',
    ],
    'invokables' => [
         // Load adapter
        'ImgMan\Adapter\Imagick' => 'ImgMan\Core\Adapter\ImagickAdapter',
        'ImgMan\ResolverDefault' => 'ImgMan\Storage\Adapter\FileSystem\Resolver\ResolverDefault'
    ],
    \\ ...
    
];
```

You can set only one storage configuration. Configure storage (e.g Mongo) where to save the images:

```php
return [
    \\ ...
    'imgman_mongodb' => [
        'MongoDb' => [
            'database' => 'imgManStorage'
        ]
    ],
    'imgman_adapter_mongo' => [
        'Storage' => [
            'collection' => 'image_test',
            'database' => 'MongoDb'
        ]
    ],
    \\ ...
 ];
```

 E.g aws configuration:

```php
return [
    \\ ...
       'imgman_amazon_client' => [
           'AmazonS3Client' => [
               'secret' => 'testSecret',
               'key' => 'testKey',
               'region' => 'testRegion',
               'version' => 'latest',
               'name' => 'S3'
           ],
           'AmazonCloudFrontClient' => [
               'secret' => 'testSecret',
               'key' => 'testKey',
               'region' => 'testRegion',
               'version' => 'latest',
               'name' => 'CloudFront'
           ]
       ],
       'imgman_amazon_s3_service' => [
           'S3Service' => [
               'client' => 'AmazonS3Client',
               'bucket' => 'test'
           ]
       ],
       'imgman_amazon_cloud_front_service' => [
           'CloudFrontService' => [
               'client' => 'AmazonCloudFrontClient',
               'domain' => 'testdomain'
           ]
       ],
       'imgman_amazon_adapter' => [
           'Storage' => [
               's3_client' => 'S3Service',
               'cloud_front_client' => 'CloudFrontService',
               'name_strategy' => 'default',
               'name_strategy_config' => [
                   'prefix' => 'test'
               ]
           ]
       ]
    \\ ...
 ];
```

 E.g filesystem configuration:

```php
return [
    \\ ...
        'imgman_adapter_filesystem' => [
            'Storage' => [
                'path' => DIR_PATH_,
                'resolver' => 'ImgMan\ResolverDefault'
            ],
        ]
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
            'storage' => 'Storage',
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
$image = new ImgMan\Image\Image(__DIR__. '/../../../name_image.png'); //the path can be also a URL
$imgMan->grab($image, '/first/name/identifier/');
```

Finally, we can recover the image rendition we desire this way:

```php
$imageOriginal = $imgMan->get('/first/name/identifier/', 'original');
$imageThumb = $imgMan->get('/first/name/identifier/', 'thumb');
$imageThumbMaxi = $imgMan->get('/first/name/identifier/', 'thumbmaxi');
```

---

[![Analytics](https://ga-beacon.appspot.com/UA-49657176-3/imgman)](https://github.com/igrigorik/ga-beacon)

