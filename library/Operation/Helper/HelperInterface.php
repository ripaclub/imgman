<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 23/05/14
 * Time: 16.25
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\Adapter\AdapterInterface;

interface HelperInterface
{
    /**
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter);

    /**
     * @return mixed
     */
    public function getAdapter();

}