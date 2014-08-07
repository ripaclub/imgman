#Img-man

##Requisites

- Php 5.5

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
                        'ImgMan\Adapter\Imagick'  => 'ImgManLibrary\Core\Adapter\ImagickAdapter',
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

   $entity = new ImageContainer(__DIR__. '/../../../prova.png');
   $serviceImgMan->grab($entity, 'prova/prova/prova');

   $image = $serviceImgMan->get('prova/prova/prova', 'thumb');


```