<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Extension\Image;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/31/15 10:28 PM
 */
class ImageOptionHelper
{

    public static function getOption($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if ('jpg' === $extension) {
            return array('jpeg_quality' => 100);
        }

        if ('png' === $extension) {
            return array('png_compression_level' => 9);
        }

        return array();
    }
}
