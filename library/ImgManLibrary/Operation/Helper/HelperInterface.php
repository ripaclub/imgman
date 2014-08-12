<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 23/05/14
 * Time: 16.25
 */

namespace ImgManLibrary\Operation\Helper;

use ImgManLibrary\Core\CoreInterface;

interface HelperInterface
{
    /**
     * @param CoreInterface $adapter
     */
    public function setAdapter(CoreInterface $adapter);

    /**
     * @return CoreInterface
     */
    public function getAdapter();

    /**
     * @param array $params
     */
    public function execute(array $params);

}