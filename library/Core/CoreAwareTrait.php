<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 29/05/14
 * Time: 13.14
 */

namespace ImgManLibrary\Core;


trait CoreAwareTrait
{
    protected $adapter = null;

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