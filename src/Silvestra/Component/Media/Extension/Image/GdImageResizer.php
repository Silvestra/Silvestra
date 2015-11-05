<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Extension\Image;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Palette\RGB;
use Imagine\Image\Point;
use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Image\Cache\ImageCacheInterface;
use Silvestra\Component\Media\Image\Resizer\ImageResizerHelper;
use Silvestra\Component\Media\Image\Resizer\ImageResizerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/2/14 10:49 PM
 */
class GdImageResizer implements ImageResizerInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ImageCacheInterface
     */
    private $imageCache;

    /**
     * @var ImageResizerHelper
     */
    private $resizeHelper;

    /**
     * @var string|array|integer
     */
    private $color;

    /**
     * @var integer|null
     */
    private $alpha;

    /**
     * Constructor.
     *
     * @param Filesystem          $filesystem
     * @param ImageCacheInterface $imageCache
     * @param ImageResizerHelper  $resizeHelper
     * @param string|array|int    $color
     * @param int|null            $alpha
     */
    public function __construct(
        Filesystem $filesystem,
        ImageCacheInterface $imageCache,
        ImageResizerHelper $resizeHelper,
        $color,
        $alpha
    ) {
        $this->filesystem = $filesystem;
        $this->imageCache = $imageCache;
        $this->resizeHelper = $resizeHelper;
        $this->color = $color;
        $this->alpha = $alpha;
    }

    /**
     * {@inheritdoc}
     */
    public function resize($imagePath, array $size, $mode, $force = false)
    {
        $cacheKey = $this->getCacheKey($size, $mode);
        $filename = basename($imagePath);

        if ((false === $force) && $this->imageCache->contains($filename, $cacheKey)) {
            return $this->imageCache->getRelativePath($filename, $cacheKey);
        }

        $cacheAbsolutePath = $this->imageCache->getAbsolutePath($filename, $cacheKey);
        $imagine = new Imagine();
        $imagineImage = $imagine->open($this->filesystem->getRootDir() . $imagePath);
        $imageSize = [$imagineImage->getSize()->getWidth(), $imagineImage->getSize()->getHeight()];
        $boxSize = $this->resizeHelper->getBoxSize($imageSize, $size);
        $box = $this->getBox($boxSize[0], $boxSize[1]);

        if (ImageResizerInterface::INSET === $mode) {
            $imageSizeInBox = $this->resizeHelper->getImageSizeInBox($imageSize, $boxSize);
            $imagineImage->resize($this->getBox($imageSizeInBox[0], $imageSizeInBox[1]));

            $palette = new RGB();
            $box = $imagine->create($box, $palette->color($this->color, $this->alpha));
            $imagineImage = $box->paste($imagineImage, $this->getPointInBox($imageSizeInBox, $boxSize));
        } else {
            $imagineImage = $imagineImage->thumbnail($box);
        }

        $this->filesystem->mkdir(dirname($cacheAbsolutePath));
        $imagineImage->save($cacheAbsolutePath, ImageOptionHelper::getOption($filename));

        return $this->imageCache->getRelativePath($filename, $cacheKey);
    }

    /**
     * Get cache key.
     *
     * @param array  $size
     * @param string $mode
     *
     * @return string
     */
    private function getCacheKey(array $size, $mode)
    {
        list($width, $height) = $size;

        return md5($width . $height . $mode);
    }

    /**
     * Get box.
     *
     * @param int $width
     * @param int $height
     *
     * @return Box
     */
    private function getBox($width, $height)
    {
        return new Box($width, $height);
    }

    /**
     * Get point in box.
     *
     * @param array $imageSize
     * @param array $boxSize
     *
     * @return Point
     */
    private function getPointInBox(array $imageSize, array $boxSize)
    {
        $width = 0;
        $height = 0;

        list($imageWidth, $imageHeight) = $imageSize;
        list($boxWidth, $boxHeight) = $boxSize;

        if ($imageWidth < $boxWidth) {
            $width = floor(($boxWidth - $imageWidth) / 2);
        }

        if ($imageHeight < $boxHeight) {
            $height = floor(($boxHeight - $imageHeight) / 2);
        }

        return new Point($width, $height);
    }
}
