<?php
namespace ImgManLibrary\Storage\Adapter\FileSystem\Resolver;

class ResolverDefault implements ResolvePathInterface
{
    /**
     * @param $path
     * @param $id
     * @return string
     * @throws Exception\PathGeneratorException
     * @throws Exception\PathNotExistException
     */
    public function resolvePathDir($path, $id)
    {
        if(!is_dir($path)) {
            throw new Exception\PathNotExistException();
        }

        $code = md5($id);
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

    public function resolveName($id)
    {
         return md5($id);
    }


} 