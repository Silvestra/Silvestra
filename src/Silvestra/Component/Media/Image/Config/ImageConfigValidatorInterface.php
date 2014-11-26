<?php

/*
 * This file is part of the Silvestra package.
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
 * @since 11/23/14 7:34 PM
 */
interface ImageConfigValidatorInterface
{
    /**
     * Validate current image config.
     *
     * @param mixed $value
     * @param ImageDefaultConfig $defaultConfig
     *
     * @return bool
     */
    public function validate($value, ImageDefaultConfig $defaultConfig);

    /**
     * Get image config name.
     *
     * @return string
     */
    public function getConfigName();
}
