<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\FileSystem\Resolver;

use ImgMan\Storage\Exception\PathGeneratorException;
use ImgMan\Storage\Exception\PathNotExistsException;

/**
 * Class ResolverDefault
 */
class ResolverDefault implements ResolvePathInterface
{
    /**
     * @param string $path
     * @param string $identifier
     * @return string
     * @throws PathGeneratorException
     * @throws PathNotExistsException
     */
    public function resolvePathDir($path, $identifier)
    {
        if (!is_dir($path)) {
            throw new PathNotExistsException(sprintf('The dir %s not exist', $path));
        }

        $code = md5($identifier);
        $pathDestination = $path . DIRECTORY_SEPARATOR . $code;

        if (is_dir($pathDestination)) {
            return $pathDestination;
        } else {
            if (mkdir($pathDestination)) {
                return $pathDestination;
            } else {
                throw new PathGeneratorException(sprintf('Unable to create directory "%s"', $pathDestination));
            }
        }
    }

    /**
     * @param string $identifier
     * @return string
     */
    public function resolveName($identifier)
    {
         return md5($identifier);
    }
}
