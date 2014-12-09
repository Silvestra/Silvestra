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
use Imagine\Image\Palette\RGB as RGBPalette;
use Imagine\Image\Palette\Color\RGB;
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
     * Constructor.
     *
     * @param Filesystem $filesystem
     * @param ImageCacheInterface $imageCache
     * @param ImageResizerHelper $resizeHelper
     */
    public function __construct(
        Filesystem $filesystem,
        ImageCacheInterface $imageCache,
        ImageResizerHelper $resizeHelper
    ) {
        $this->filesystem = $filesystem;
        $this->imageCache = $imageCache;
        $this->resizeHelper = $resizeHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function resize($imagePath, array $size, $mode, $force = false)
    {
        $cacheKey = $this->getCacheKey($imagePath, $size, $mode);
        $filename = $this->getFilename($imagePath);

        if ((false === $force) && $this->imageCache->contains($filename, $cacheKey)) {
            return $this->imageCache->getRelativePath($filename, $cacheKey);
        }

        $cacheAbsolutePath = $this->imageCache->getAbsolutePath($filename, $cacheKey);
        $imagine = new Imagine();
        $imagineImage = $imagine->open($this->filesystem->getRootDir() . $imagePath);
        $imageSize = array($imagineImage->getSize()->getWidth(), $imagineImage->getSize()->getHeight());
        $boxSize = $this->resizeHelper->getBoxSize($imageSize, $size);
//        $box = new Box($boxSize[0], $boxSize[1]);


//        if (ImageResizerInterface::THUMBNAIL_INSET === $mode) {

        $imageSizeInBox = $this->resizeHelper->getImageSizeInBox($imageSize, $boxSize);
        $imagineImage->resize(new Box($imageSizeInBox[0], $imageSizeInBox[1]));

//        $box = $imagine->create($box, new RGB(new RGBPalette(), array('#fff'), 100));
//        $imagineImage = $box->paste($imagineImage, new Point($point[0], $point[1]));
//        } else {
//            $imagineImage->thumbnail($this->getBox($width, $height), $mode);
//        }

        $this->filesystem->mkdir(dirname($cacheAbsolutePath));
        $imagineImage->save($cacheAbsolutePath, array('quality' => 100));

        return $this->imageCache->getRelativePath($filename, $cacheKey);
    }

    /**
     * Get cache key.
     *
     * @param string $imagePath
     * @param array $size
     * @param string $mode
     *
     * @return string
     */
    private function getCacheKey($imagePath, array $size, $mode)
    {
        list($width, $height) = $size;

        return md5($imagePath) . DIRECTORY_SEPARATOR . md5($width . $height . $mode);
    }

    /**
     * Get filename.
     *
     * @param string $path
     *
     * @return string
     */
    private function getFilename($path)
    {
        return basename($path);
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
}
