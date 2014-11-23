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

use Silvestra\Component\Media\Exception\InvalidArgumentException;
use Silvestra\Component\Media\Image\ImageConfigValidatorInterface;
use Silvestra\Component\Media\Image\ImageDefaultConfig;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 7:44 PM
 */
class MimeTypesValidator implements ImageConfigValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, ImageDefaultConfig $defaultConfig)
    {
        if (!is_array($value)) {
            throw new InvalidArgumentException('Mime types must be array!');
        }

        foreach ($value as $mimeType) {
            if (!in_array($mimeType, $defaultConfig->getAvailableMimeTypes())) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigName()
    {
        return 'mime_types';
    }
}
