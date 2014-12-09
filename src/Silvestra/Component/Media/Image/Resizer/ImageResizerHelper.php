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
class ImageResizerHelper
{
    public function calculateBoxSize(array $imageSize, array $size)
    {
        list($width, $height) = $size;

        if ((null == $width) && (null == $height)) {
            return $imageSize;
        }

        list($imageWidth, $imageHeight) = $imageSize;

        if ((null !== $width) && (null == $height)) {
            $height = ceil($width * ($imageHeight / $imageWidth));

            if ($height > $imageHeight) {
                $height = $imageHeight;
            }

            return array($width, $height);
        }

        if ((null === $width) && (null != $height)) {
            $width = ceil($height * ($imageWidth / $imageHeight));

            if ($width > $imageWidth) {
                $width = $imageWidth;
            }

            return array($width, $height);
        }

        return $size;
    }

    public function calculateImageSizeByBox(array $imageSize, array $boxSize)
    {
        list($imageWidth, $imageHeight) = $imageSize;
        list($boxWidth, $boxHeight) = $boxSize;

        if (($imageWidth <= $boxWidth) && ($imageHeight <= $boxHeight)) {
            return $imageSize;
        }

        $resizeRatio = min($boxWidth / $imageWidth, $boxHeight / $imageHeight);

        $imageWidth = ceil($imageWidth * $resizeRatio);

        if ($imageWidth > $boxWidth) {
            $imageWidth = $boxWidth;
        }

        $imageHeight = ceil($imageHeight * $resizeRatio);

        if ($imageHeight > $boxHeight) {
            $imageHeight = $boxHeight;
        }

        return array($imageWidth, $imageHeight);
    }
}
