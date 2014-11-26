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

        $imageFile->crop($this->getStartPoint($coordinates['x1'], $coordinates['y1']), $this->getBox($coordinates));
        $imageFile->save($this->fileSystem->getAbsoluteFilePath($image->getFilename(), Filesystem::CROPPER_SUB_DIR));

        return $this->fileSystem->getRelativeFilePath($image->getFilename(), Filesystem::CROPPER_SUB_DIR);
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
}
