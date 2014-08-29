<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Storage\Adapter\FileSystem\Resolver;

class ResolverDefault implements ResolvePathInterface
{
    /**
     * @param string $path
     * @param string $identifier
     * @return string
     * @throws Exception\PathGeneratorException
     * @throws Exception\PathNotExistException
     */
    public function resolvePathDir($path, $identifier)
    {
        if(!is_dir($path)) {
            throw new Exception\PathNotExistException();
        }

        $code = md5($identifier);
        $pathDestination = $path . '/' . $code;

        if(is_dir($pathDestination)) {
            return $pathDestination;

        } else {
            if(mkdir($pathDestination)) {
                return $pathDestination;

            } else {
                throw new Exception\PathGeneratorException();
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
