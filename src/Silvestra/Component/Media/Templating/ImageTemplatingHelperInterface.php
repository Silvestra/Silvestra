<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Templating;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/6/14 6:38 PM
 */
interface ImageTemplatingHelperInterface
{
    /**
     * Render image html tag.
     *
     * @param string $filename
     * @param array $size
     * @param null|string $mode
     * @param array $attributes
     *
     * @return string
     */
    public function renderImageHtmlTag($filename, array $size, $mode = null, array $attributes = array());

    /**
     * Resize image.
     *
     * @param string $filename
     * @param array $size
     * @param null|string $mode
     *
     * @return string
     */
    public function resizeImage($filename, array $size, $mode = null);
}
