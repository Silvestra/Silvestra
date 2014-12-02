<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/2/14 10:53 PM
 */
interface ImageResizerInterface
{
    const THUMBNAIL_INSET    = 'inset';
    const THUMBNAIL_OUTBOUND = 'outbound';

    /**
     * Resize image.
     *
     * @param string $path
     * @param int $with
     * @param int $height
     * @param string $mode
     * @param bool $force
     *
     * @return string
     */
    public function resize($path, $with, $height, $mode, $force = false);
}
