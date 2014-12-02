<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image\Config;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/26/14 10:50 PM
 */
class ImageConfigHelper
{
    /**
     * Normalize image config.
     *
     * @param array $config
     *
     * @return array
     */
    public static function normalize(array $config)
    {
        $config['mime_types'] = (array)$config['mime_types'];
        $config['cropper_enabled'] = (bool)$config['cropper_enabled'];
        $config['max_file_size'] = (int)$config['max_file_size'];
        $config['max_height'] = (int)$config['max_height'];
        $config['max_width'] = (int)$config['max_width'];
        $config['min_height'] = (int)$config['min_height'];
        $config['min_width'] = (int)$config['min_width'];
        $config['cropper_coordinates'] = array_map('intval', $config['cropper_coordinates']);

        return $config;
    }
}
