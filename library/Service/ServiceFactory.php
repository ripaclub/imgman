<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 19/05/14
 * Time: 13.11
 */

namespace ImgManLibrary\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceFactory implements AbstractFactoryInterface
{

    /**
     * Config Key
     * @var string
     */
    protected $configKey = 'imgManServices';

    /**
     * Default service class name
     *
     * @var string
     */
    protected $serviceNameClass = 'ImgManLibrary\Service\ServiceImplement';

    /**
     * Config
     * @var array
     */
    protected $config;

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        // TODO: Implement canCreateServiceWithName() method.
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param $name
     * @param $requestedName
     * @return mixed
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        // TODO: Implement createServiceWithName() method.
    }

} 