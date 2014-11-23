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
use Silvestra\Component\Media\Media;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 7:44 PM
 */
class ResizeStrategyValidator implements ImageConfigValidatorInterface
{

    /**
     * {@inheritdoc}
     */
    public function validate($value, ImageDefaultConfig $defaultConfig)
    {
        return in_array($value, Media::getResizeStrategies());
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigName()
    {
        return 'resize_strategy';
    }
}
