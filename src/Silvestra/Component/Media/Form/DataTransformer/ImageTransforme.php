<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Form\DataTransformer;

use Silvestra\Component\Media\Model\ImageInterface;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 4:04 PM
 */
class ImageTransformer implements DataTransformerInterface
{

    /**
     * Transform.
     *
     * @param ImageInterface $image
     *
     * @return ImageInterface
     */
    public function transform($image)
    {
        return $image;
    }

    /**
     * Reverse transform.
     *
     * @param ImageInterface $image
     *
     * @return ImageInterface
     */
    public function reverseTransform($image)
    {
        $image->setCropperCoordinates(json_decode($image->getCropperCoordinates(), true));

        return $image;
    }
}
