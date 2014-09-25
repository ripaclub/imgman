Image manager [![Build Status](https://travis-ci.org/ripaclub/imgman.png?branch=master)](https://travis-ci.org/ripaclub/imgman)&nbsp;[![Latest Stable Version](https://poser.pugx.org/ripaclub/imgman/v/stable.png)](https://packagist.org/packages/ripaclub/imgman)&nbsp;
=============

Image Manager is a library that allows you to create various image renditions from a picture.

You can modify an image (e.g., resize, crop, format, fit in, fit out, rotate) and save different renditions stored in your configuration.

The library consists of the following components:

- Core

- Operation

- Service

- Storage

- Image

## Requisites

- PHP >= 5.4

- Composer

- Imagick

## Configuration

Configure service manager with factory service, plugin manager, storage and adapter. E.g.:

```php
$serviceManager = new ServiceManager\ServiceManager(
    new ServiceManagerConfig([
            'abstract_factories' => [
                // Load abstract service
                'ImgManLibrary\Service\ServiceFactory',
                // Load abstract mongo db connection
                'ImgManLibrary\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
                // Load abstract mongo collection
                'ImgManLibrary\Storage\Adapter\Mongo\MongoCollectionAbstractServiceFactory',
            ],
            'factories' => [
                // Load operation plugin manager
                'ImgMan\PluginManager' => 'ImgManLibrary\Operation\OperationHelperManagerFactory',
            ],
            'invokables' => [
                // Load adapter
                'ImgMan\Adapter\Imagick' => 'ImgManLibrary\Core\Adapter\ImagickAdapter',
            ],
        ]
    )
);
```

Config mongo database connection and mongo collection. E.g.:

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
    \\ ...
 ];
```

Config imgman service. E.g.:

```php
$config = [
    \\ ...
        'imgman_services' => [
            'ImgMan\Service\First' => [
                'adapter' => 'ImgMan\Adapter\Imagick',
                'storage' => 'ImgMan\Storage\Mongo',
                'pluginManager' => 'ImgMan\PluginManager',
                'renditions' => [
                    'thumb' => [
                        'resize' => [
                            'width'  => 200,
                            'height' => 200
                        ]
                    ],
                    'thumbMaxi' => [
                        'resize' => [
                            'width'  => 400,
                            'height' => 400
                        ]
                    ]
                ],
            ]
        ]
    \\ ...
 ];
```

Add configuration to service manager. E.g.:

```php
$serviceManager->setService('Config', $config);
```

## Usage

```php
$serviceManager = $this->getServiceLocator()->get('ImgMan\Service\Test');

$image = new ImageContainer(__DIR__. '/../../../name_image.png');
$serviceImgMan->grab($image, 'test/name/identifier');

$image = $serviceImgMan->get('test/name/identifier', 'thumb');
```

---

[![Analytics](https://ga-beacon.appspot.com/UA-49655829-1/ripaclub/imgman)](https://github.com/igrigorik/ga-beacon)