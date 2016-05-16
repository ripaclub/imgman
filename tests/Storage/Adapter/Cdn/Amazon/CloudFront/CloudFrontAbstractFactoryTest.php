<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage\Adapter\Cdn\Amazon\S3;

use ImgMan\Storage\Adapter\Cdn\Amazon\ClientManager;
use ImgManTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * Class CloudFrontAbstractFactoryTest
 */
class CloudFrontAbstractFactoryTest extends ImageManagerTestCase
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $config = [
            'imgman_amazon_client' => [
                'Amazon' => [
                    'secret' => 'testSecret',
                    'key' => 'testKey',
                    'region' => 'testRegion',
                    'version' => 'latest',
                    'name' => 'CloudFront'
                ]
            ],
            'imgman_amazon_cloud_front_service' => [
                'AmazonService' => [
                    'client' => 'Amazon',
                    'domain' => 'testdomain',
                    'origin' => 'testorigin'
                ]

            ]
        ];
        $this->serviceManager = new ServiceManager(
            new ServiceManagerConfig(
                [
                    'abstract_factories' => [
                        'ImgMan\Storage\Adapter\Cdn\Amazon\CloudFront\CloudFrontServiceAbstractFactory',
                    ],
                    'factories' => [
                        ClientManager::class => 'ImgMan\Storage\Adapter\Cdn\Amazon\ClientManagerFactory'
                    ]
                ]
            )
        );

        $this->serviceManager->setService('Config', $config);
    }

    public function testAmazonAbstractServiceFactory()
    {
        $this->assertTrue($this->serviceManager->has('AmazonService'));
        $this->assertInstanceOf(
            'ImgMan\Storage\Adapter\Cdn\Amazon\CloudFront\CloudFrontServiceInterface',
            $this->serviceManager->get('AmazonService')
        );
    }
}