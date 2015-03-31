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
use Imagine\Image\Point;
use Silvestra\Component\Media\Exception\NotFoundImageException;
use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Image\ImageCropperInterface;
use Silvestra\Component\Media\Model\ImageInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/24/14 10:06 PM
 */
class GdImageCropper implements ImageCropperInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function crop(ImageInterface $image, array $coordinates)
    {
        $absolutePath = $this->filesystem->getRootDir() . $image->getOriginalPath();

        if (false === file_exists($absolutePath)) {
            throw new NotFoundImageException(sprintf('Not found image in %s', $absolutePath));
        }

        $this->filesystem
            ->mkdir($this->filesystem->getActualFileDir($image->getFilename(), Filesystem::CROPPER_SUB_DIR));

        $imagine = new Imagine();

        $imagine->open($absolutePath)
            ->crop($this->getStartPoint($coordinates['x1'], $coordinates['y1']), $this->getBox($coordinates))
            ->save(
                $this->filesystem->getAbsoluteFilePath($image->getFilename(), Filesystem::CROPPER_SUB_DIR),
                ImageOptionHelper::getOption($image->getFilename())
            );

        return $this->filesystem->getRelativeFilePath($image->getFilename(), Filesystem::CROPPER_SUB_DIR);
    }

    /**
     * Get start point.
     *
     * @param int $x
     * @param int $y
     *
     * @return Point
     */
    private function getStartPoint($x, $y)
    {
        return new Point($x, $y);
    }

    /**
     * Get box.
     *
     * @param array $coordinates
     *
     * @return Box
     */
    private function getBox(array $coordinates)
    {
        $height = abs($coordinates['y1'] - $coordinates['y2']);
        $width = abs($coordinates['x1'] - $coordinates['x2']);

        return new Box($width, $height);
    }
}
