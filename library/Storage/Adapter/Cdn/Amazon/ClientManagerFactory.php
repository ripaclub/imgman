<?php
namespace ImgMan\Storage\Adapter\Cdn\Amazon;

use Aws\AwsClientInterface;
use ImgMan\Storage\Adapter\Cdn\Amazon\S3\S3ClientAbstractFactory;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\Exception;

/**
 * Class ClientManager
 */
class ClientManager extends AbstractPluginManager
{
    /**
     * Constructor
     * Add a default initializer to ensure the plugin is valid after instance creation.
     *
     * @param  null|ConfigInterface $configuration
     */
    public function __construct(ConfigInterface $configuration = null)
    {
        parent::__construct($configuration);
        $this->addAbstractFactory(new ClientAbstractFactory());
    }

    public function validatePlugin($plugin)
    {

        if (!($plugin instanceof AwsClientInterface)) {

            throw new Exception\RuntimeException(sprintf(
                'Type "%s" is invalid; must be an object',
                gettype($plugin)
            ));
        }
    }

}