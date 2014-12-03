<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Extension\Image;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Image\Cache\ImageCacheInterface;
use Silvestra\Component\Media\Image\ImageResizerInterface;
use Silvestra\Component\Media\Model\ImageInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/2/14 10:49 PM
 */
class ImageResizer implements ImageResizerInterface
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
     * Constructor.
     *
     * @param Filesystem $filesystem
     * @param ImageCacheInterface $imageCache
     */
    public function __construct(Filesystem $filesystem, ImageCacheInterface $imageCache)
    {
        $this->filesystem = $filesystem;
        $this->imageCache = $imageCache;
    }

    /**
     * {@inheritdoc}
     */
    public function resize(ImageInterface $image, $with, $height, $mode, $force = false)
    {
        $cacheKey = $this->getCacheKey($image->getPath()) . DIRECTORY_SEPARATOR . $this->getCacheKey($with . $height . $mode);

        if (false === $force && $this->imageCache->contains($image->getFilename(), $cacheKey)) {
            return $this->imageCache->getRelativePath($image->getFilename(), $cacheKey);
        }

        $cacheAbsolutePath = $this->imageCache->getAbsolutePath($image->getFilename(), $cacheKey);
        $imagine = new Imagine();

        $this->filesystem->mkdir(dirname($cacheAbsolutePath));

        $imagineImage = $imagine->open($this->filesystem->getRootDir() . $image->getPath());

//        if (ImageResizerInterface::THUMBNAIL_INSET === $mode) {
//            $imagineImage->resize($this->getBox($with, $height), $mode);
//        } else {
            $imagineImage->thumbnail($this->getBox($with, $height), $mode);
//        }
        $imagineImage->save($cacheAbsolutePath, array('quality' => 100));

        return $this->imageCache->getRelativePath($image->getFilename(), $cacheKey);
    }

    /**
     * Get cache key.
     *
     * @param string $value
     *
     * @return string
     */
    private function getCacheKey($value)
    {
        return md5($value);
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
