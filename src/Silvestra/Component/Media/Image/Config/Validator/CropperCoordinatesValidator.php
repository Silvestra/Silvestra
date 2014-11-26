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

use Silvestra\Component\Media\Exception\InvalidArgumentException;
use Silvestra\Component\Media\Image\Config\ImageConfigValidatorInterface;
use Silvestra\Component\Media\Image\Config\ImageDefaultConfig;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 7:45 PM
 */
class CropperCoordinatesValidator implements ImageConfigValidatorInterface
{

    /**
     * {@inheritdoc}
     */
    public function validate($value, ImageDefaultConfig $defaultConfig)
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException('Cropper coordinates must be array!');
        }

        return (4 === count($value));
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigName()
    {
        return 'cropper_coordinates';
    }
}
