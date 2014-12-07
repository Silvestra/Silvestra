<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image\Config\Validator;

use Silvestra\Component\Media\Image\Config\ImageConfigValidatorInterface;
use Silvestra\Component\Media\Image\Config\ImageDefaultConfig;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 7:44 PM
 */
class CropperEnabledValidator implements ImageConfigValidatorInterface
{

    /**
     * {@inheritdoc}
     */
    public function validate($value, ImageDefaultConfig $defaultConfig)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigName()
    {
        return 'cropper_enabled';
    }
}
