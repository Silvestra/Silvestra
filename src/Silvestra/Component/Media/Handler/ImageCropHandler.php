<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Handler;

use Silvestra\Component\Media\Image\ImageCropperInterface;
use Silvestra\Component\Media\Model\ImageInterface;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/26/14 8:27 PM
 */
class ImageCropHandler
{
    /**
     * @var ImageCropperInterface
     */
    private $imageCropper;

    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * Constructor.
     *
     * @param ImageCropperInterface $imageCropper
     * @param ImageManagerInterface $imageManager
     */
    public function __construct(ImageCropperInterface $imageCropper, ImageManagerInterface $imageManager)
    {
        $this->imageCropper = $imageCropper;
        $this->imageManager = $imageManager;
    }

    /**
     * Process image crop.
     *
     * @param array $coordinates
     * @param ImageInterface $image
     *
     * @return array
     */
    public function process(array $coordinates, ImageInterface $image)
    {
        $path = $this->imageCropper->crop($image, $coordinates);

        $image->setCropperCoordinates($coordinates);
        $image->setPath($path);

        $this->imageManager->save();

        return array(
            'original_path' => $image->getOriginalPath(),
            'path' => $image->getPath()
        );
    }
}
