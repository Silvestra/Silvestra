<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image\Resizer;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/2/14 10:53 PM
 */
interface ImageResizerInterface
{
    const INSET    = 'inset';
    const OUTBOUND = 'outbound';

    /**
     * Resize image.
     *
     * @param string $imagePath
     * @param array $size
     * @param string $mode
     * @param bool $force
     *
     * @return string
     */
    public function resize($imagePath, array $size, $mode, $force = false);
}
