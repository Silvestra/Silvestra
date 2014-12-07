<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 2:01 PM
 */
class Media
{
    /**
     * Silvestra media name.
     */
    const NAME = 'silvestra_media';

    /**
     * Image mime types.
     *
     * @var array
     */
    private static $imageMimeTypes = array(
        'image/png',
        'image/jpeg',
        'image/gif',
        'image/bmp',
        'image/vnd.microsoft.icon',
        'image/tiff',
        'image/svg+xml'
    );

    /**
     * Image resize strategies.
     *
     * @var array
     */
    private static $resizeStrategies = array('min', 'max', 'preview', 'width', 'height');

    /**
     * Get image mime types.
     *
     * @return array
     */
    public static function getImageMimeTypes()
    {
        return self::$imageMimeTypes;
    }

    /**
     * Get image resize strategies.
     *
     * @return array
     */
    public static function getResizeStrategies()
    {
        return self::$resizeStrategies;
    }
}
