<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Cropper;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Silvestra\Component\Media\Exception\NotFoundImageException;
use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Model\ImageInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/24/14 10:06 PM
 */
class ImageCropper
{
    const SUB_DIR_NAME = 'cropper';

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * Constructor.
     *
     * @param Filesystem $fileSystem
     */
    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function crop(ImageInterface $image, array $coordinates)
    {
        if (!file_exists($image->getOriginalPath())) {
            throw new NotFoundImageException(sprintf('Not found image in %s', $image->getOriginalPath()));
        }

        $imagine = new Imagine();
        $imageFile = $imagine->open($image->getOriginalPath());
        $path = $this->getCroppedImagePath($image->getFilename());

        $imageFile->crop($this->getStartPoint($coordinates['x1'], $coordinates['y1']), $this->getBox($coordinates));
        $imageFile->save($path);

        return $path;
    }

    private function getStartPoint($x, $y)
    {
        return new Point($x, $y);
    }

    private function getBox(array $coordinates)
    {
        $height = $coordinates['y1'] - $coordinates['y2'];
        $width = $coordinates['x1'] - $coordinates['x2'];

        return new Box($width, $height);
    }

    /**
     * Get cropped image path.
     *
     * @param string $filename
     *
     * @return string
     */
    private function getCroppedImagePath($filename)
    {
        return $this->getCropperRootDir() . DIRECTORY_SEPARATOR .
                $this->fileSystem->getFileDirPrefix($filename) . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * Get cropper root dir.
     *
     * @return string
     */
    public function getCropperRootDir()
    {
        return $this->fileSystem->getMediaRootDir() . DIRECTORY_SEPARATOR . self::SUB_DIR_NAME;
    }
}
