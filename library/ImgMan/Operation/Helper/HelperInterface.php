<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Operation\Helper;

use ImgMan\Core\CoreInterface;

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
