<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgManTest\Storage\Adapter\Cdn\Amazon;

use ImgManTest\ImageManagerTestCase;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * Class S3ClientAbstractFactoryTest
 */
class ClientAbstractFactoryTest extends ImageManagerTestCase
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
                    'name' => 'S3'
                ]
            ],
        ];
        $this->serviceManager = new ServiceManager(
            new ServiceManagerConfig(
                [
                    'abstract_factories' => [
                        'ImgMan\Storage\Adapter\Cdn\Amazon\ClientAbstractFactory',
                    ],
                ]
            )
        );

        $this->serviceManager->setService('Config', $config);
    }

    public function testAmazonAbstractServiceFactory()
    {
        $this->assertTrue($this->serviceManager->has('Amazon'));
        $this->assertInstanceOf('Aws\AwsClientInterface', $this->serviceManager->get('Amazon'));
        $this->assertInstanceOf('Aws\S3\S3Client', $this->serviceManager->get('Amazon'));
    }
}