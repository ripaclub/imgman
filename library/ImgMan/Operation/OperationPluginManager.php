<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation;

use ImgMan\Core\CoreAwareInterface;
use ImgMan\Core\CoreAwareTrait;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;

/**
 * Class OperationPluginManager
 */
class OperationPluginManager extends AbstractPluginManager implements CoreAwareInterface
{
    use CoreAwareTrait;
    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = [
        'fitIn'         => 'ImgMan\Operation\Helper\FitIn',
        'fitOut'        => 'ImgMan\Operation\Helper\FitOut',
        'resize'        => 'ImgMan\Operation\Helper\Resize',
        'scaleToHeight' => 'ImgMan\Operation\Helper\ScaleToHeight',
        'scaleToWidth'  => 'ImgMan\Operation\Helper\ScaleToWidth',
        'crop'          => 'ImgMan\Operation\Helper\Crop',
        'format'        => 'ImgMan\Operation\Helper\Format',
        'compression'   => 'ImgMan\Operation\Helper\Compression',
        'rotate'        => 'ImgMan\Operation\Helper\Rotate',
    ];

    /**
     * Ctor
     * @param ConfigInterface $configuration
     */
    public function __construct(ConfigInterface $configuration = null)
    {
        parent::__construct($configuration);
        // FIXME: set him from config (not in the ctor)
        foreach ($this->invokableClasses as $key => $value) {
            $this->setInvokableClass($key, $value);
        }

        $this->addInitializer([$this, 'injectAdapter']);
    }

    /**
     * @param $helper
     */
    public function injectAdapter($helper)
    {
        /* @var \ImgMan\Operation\Helper\HelperInterface $helper */
        if ($this->getAdapter()) {
            $helper->setAdapter($this->getAdapter());
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
            return;
        }

        throw new Exception\InvalidHelperException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Helper\HelperInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}
