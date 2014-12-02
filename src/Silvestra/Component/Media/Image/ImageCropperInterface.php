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

use Silvestra\Component\Media\Exception\NotFoundImageException;
use Silvestra\Component\Media\Model\ImageInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/2/14 10:52 PM
 */
interface ImageCropperInterface
{
    /**
     * Crop image.
     *
     * @param ImageInterface $image
     * @param array $coordinates
     *
     * @return string
     *
     * @throws NotFoundImageException
     */
    public function crop(ImageInterface $image, array $coordinates);
}
