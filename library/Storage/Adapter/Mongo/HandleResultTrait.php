<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\Mongo;

use ImgMan\Storage\Adapter\Mongo\Exception\MongoResultException;

/**
 * Class HandleResultTrait
 */
trait HandleResultTrait
{
    /**
     * @param $result
     * @param $isRemoveOperation
     * @return int|null
     */
    protected function handleResult($result, $isRemoveOperation = false)
    {
        // No info available
        if ($result === true) {
            return null;
        }

        if (is_array($result)) {
            // $result['ok'] should always be 1 (unless last_error itself failed)
            if (isset($result['ok']) && $result['ok']) {
                if ($isRemoveOperation || isset($result['updatedExisting'])) {
                    return isset($result['n']) ? (int) $result['n'] : null;
                } else {
                    return 1; // MongoDB returns 0 on insert operation
                }
            }

            if (isset($result['err']) && $result['err'] !== null) {
                throw new MongoResultException($result['errmsg'], $result['code']);
            }
        }

        return null;
    }
}
