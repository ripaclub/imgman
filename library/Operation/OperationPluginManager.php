<?php

namespace ImgManLibrary\Operation;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceManager;

class OperationPluginManager extends AbstractPluginManager
{
    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = array(
        'fitIn' => 'ImgManLibrary\Operation\Helper\FitIn'
    );

    public function __construct(ConfigInterface $configuration = null)
    {
        parent::__construct($configuration);
        // FIXME settarlo da configurazione e non nel costruttore
        foreach ($this->invokableClasses as $key => $value) {
            $this->setInvokableClass($key, $value);
        }

        $this->addInitializer(array($this, 'injectAdapter'));
    }

    /**
     * @param $helper
     */
    public function injectAdapter($helper)
    {
        /* @var ImgManLibrary\Operation\Helper\HelperInterface $helper */
        $locator = $this->getServiceLocator();

        if ($locator->has('imgManAdapter')) {
            $helper->setAdapter($locator->get('imgManAdapter'));
            return;
        }
    }


    /**
     * @param mixed $plugin
     * @throws Exception\InvalidHelperException
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof Helper\HelperInterface) {
            // we're okay
            return;
        }

        throw new Exception\InvalidHelperException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Helper\HelperInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }

} 