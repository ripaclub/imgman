<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Hydrator;

use Zend\Stdlib\Hydrator\NamingStrategy\NamingStrategyInterface;

/**
 * Class DefaultNamingStrategy
 */
class DefaultNamingStrategy implements NamingStrategyInterface
{

    /**
     * @var string
     */
    protected $prefix;

    /**
     * DefaultNamingStrategy constructor.
     * @param array $options
     */
    public function __construct($options = null)
    {
        if ($options && $options['prefix']) {
            $this->setPrefix($options['prefix']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($name)
    {
        $params = explode("#", $name);

        return $this->prefix . $params[0] . '/' .$params[1];
    }

    /**
     * {@inheritdoc}
     */
    public function extract($name)
    {
        new \Exception('TODO');
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }
}