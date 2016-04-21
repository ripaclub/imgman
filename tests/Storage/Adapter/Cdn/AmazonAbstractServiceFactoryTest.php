<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage\Adapter\Cdn\Amazon;

use ImgMan\Storage\Adapter\Cdn\Amazon\ClientManager;
use ImgMan\Storage\Adapter\Cdn\AmazonAdapter;
use ImgManTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * Class AmazonAbstractServiceFactoryTest
 */
class AmazonAbstractServiceFactoryTest extends ImageManagerTestCase
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $config = [
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
                'AmazonStorageAdapter' => [
                    's3_client' => 'S3Service',
                    'cloud_front_client' => 'CloudFrontService',
                    'name_strategy' => 'default',
                    'name_strategy_config' => [
                        'prefix' => 'test'
                    ]
                ]
            ]
        ];
        $this->serviceManager = new ServiceManager(
            new ServiceManagerConfig(
                [
                    'abstract_factories' => [
                        'ImgMan\Storage\Adapter\Cdn\Amazon\S3\S3ServiceAbstractFactory',
                        'ImgMan\Storage\Adapter\Cdn\Amazon\CloudFront\CloudFrontServiceAbstractFactory',
                        'ImgMan\Storage\Adapter\Cdn\AmazonAdapterAbstractFactory',
                    ],
                    'factories' => [
                        'ImgMan\PluginManager' => 'ImgMan\Operation\HelperPluginManagerFactory',
                        'ImgMan\Hydrator\NameStrategyManager' => 'ImgMan\Hydrator\NameStrategyManagerFactory',
                        'ImgMan\Storage\Adapter\Cdn\Amazon\ClientManager' => 'ImgMan\Storage\Adapter\Cdn\Amazon\ClientManagerFactory'
                    ]
                ]
            )
        );

        $this->serviceManager->setService('Config', $config);
    }

    public function testAmazonAbstractServiceFactory()
    {
        $this->assertTrue($this->serviceManager->has('AmazonStorageAdapter'));
        $this->assertInstanceOf('ImgMan\Storage\StorageInterface', $this->serviceManager->get('AmazonStorageAdapter'));
    }
}
