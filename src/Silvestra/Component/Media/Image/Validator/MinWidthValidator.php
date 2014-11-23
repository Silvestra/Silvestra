<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image\Validator;

use Silvestra\Component\Media\Image\ImageConfigValidatorInterface;
use Silvestra\Component\Media\Image\ImageDefaultConfig;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 7:40 PM
 */
class MinWidthValidator implements ImageConfigValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, ImageDefaultConfig $defaultConfig)
    {
        return ($defaultConfig->getMinWidth() <= $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigName()
    {
        return 'min_width';
    }
}
