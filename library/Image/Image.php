<?php
/**
 * Image Manager
 *
 * @link        https://github.com/ripaclub/imgman
 * @copyright   Copyright (c) 2014, RipaClub
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */
namespace ImgMan\Image;

use ImgMan\Image\Exception\FileNotFound;

/**
 * Class Image
 *
 *
 * @package ImgMan\Image
 */
class Image implements ImageInterface
{
    use ImageTrait;

    /**
     * @param $img
     * @throws FileNotFound
     */
    public function __construct($img = null)
    {
        if (is_null($img)) {
            return;
        }
        // Load file content
        $content = file_get_contents($img);
        if ($content === false) {
            throw new FileNotFound(sprintf(
                ' File not found for resource %s',
                $img)
            );
        } else {
            $this->setBlob($content);
        }
    }
}
