<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 10.36
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\CoreInterface;

abstract class AbstractHelper implements HelperInterface
{
    const DEFAULT_FORMAT = 'jpeg';

    protected $adapter;
    /**
     * @param CoreInterface $adapter
     */
    public function setAdapter(CoreInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return CoreInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
} 