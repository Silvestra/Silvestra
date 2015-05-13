<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\Controller;

use Silvestra\Component\Media\Exception\NotFoundImageException;
use Silvestra\Component\Media\Handler\ImageCropHandler;
use Silvestra\Component\Media\Image\Resizer\ImageResizerInterface;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/26/14 8:22 PM
 */
class ImageCropperController
{
    /**
     * @var ImageCropHandler
     */
    private $imageCropHandler;

    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * @var ImageResizerInterface
     */
    private $imageResizer;

    /**
     * Constructor.
     *
     * @param ImageCropHandler $imageCropHandler
     * @param ImageManagerInterface $imageManager
     * @param ImageResizerInterface $imageResizer
     */
    public function __construct(
        ImageCropHandler $imageCropHandler,
        ImageManagerInterface $imageManager,
        ImageResizerInterface $imageResizer
    ) {
        $this->imageCropHandler = $imageCropHandler;
        $this->imageManager = $imageManager;
        $this->imageResizer = $imageResizer;
    }

    public function cropAction(Request $request)
    {
        $coordinates = $request->get('coordinates', null);
        $filename = $request->get('filename', null);

        if (!$filename || (null === $coordinates)) {
            throw new NotFoundHttpException('Invalid coordinates or filename request parameters!');
        }

        $image = $this->imageManager->findByFilename($filename);
        if (null === $image) {
            throw new NotFoundImageException('Image not found!');
        }

        $data = $this->imageCropHandler->process($coordinates, $image);
        $data['thumbnail_path'] = $this->imageResizer
            ->resize($image->getPath(), array(150, 150), ImageResizerInterface::INSET);

        return new JsonResponse($data);
    }
}
