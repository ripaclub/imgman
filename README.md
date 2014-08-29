#Img-man

##Requisites

- PHP 5.4

- Composer

- Imagick (the only adapter implemented)

##Features

Img-man is a library allow you to create various image renditions from a picture. You can modify an image (resize, crop,
format, fitIn, fitOut) and storage different renditions saved in your configuration.
The library that consists of the following components:

- Core:

- Operation

- Service

- Storage

- Image

##Configuration

Configure service manager with factory service, plugin manager, storage and adapter

E.g.:
```php

$serviceManager = new ServiceManager\ServiceManager(
    new ServiceManagerConfig([
            'abstract_factories' => [
                // Load abstract service
                'ImgMan\Service\ServiceFactory',
                // Load abstract mongo db connection
                'ImgMan\Storage\Adapter\Mongo\MongoDbAbstractServiceFactory',
                // Load abstract mongo collection
                'ImgMan\Storage\Adapter\Mongo\MongoCollectionAbstractServiceFactory',
            ],
            'factories' => [
                // Load operation plugin manager
                'ImgMan\PluginManager' => 'ImgMan\Operation\OperationHelperManagerFactory',
            ],
            'invokables' => [
                // Load adapter
                'ImgMan\Adapter\Imagick'  => 'ImgMan\Core\Adapter\ImagickAdapter',
            ],
        ]
    )
);

```

Config mongo database connection and mongo collection

E.g.:
```php

$config = [
    \\ ...
        'imgManMongodb' => [
            'MongoDb' => [
                'database' => 'imgManStorage'
            ]
        ],
        'imgManMongoAdapter' => [
            'ImgMan\Storage\Mongo' => [
                'collection' => 'image_test',
                'database' => 'MongoDb'
            ]
        ],
    \\ ...
 ];

```

Config imgman service

E.g.:
```php

$config = [
    \\ ...
        'imgManServices' => [
            'ImgMan\Service\First' => [
                'adapter'       => 'ImgMan\Adapter\Imagick',
                'storage'       => 'ImgMan\Storage\Mongo',
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

Add configuration to service manager

E.g.:
```php

$serviceManager->setService('Config', $config);

```

##Usage

```php

$serviceManager = $this->getServiceLocator()->get('ImgMan\Service\Test');

$image = new ImageContainer(__DIR__. '/../../../name_image.png');
$serviceImgMan->grab($image, 'test/name/identifier');

$image = $serviceImgMan->get('test/name/identifier', 'thumb');

```