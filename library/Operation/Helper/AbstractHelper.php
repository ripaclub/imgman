<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 10.36
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\Adapter\AdapterInterface;

abstract class AbstractHelper implements HelperInterface
{
    protected $adapter;
    /**
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
} 