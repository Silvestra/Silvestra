<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\Controller;

use Silvestra\Component\Media\Handler\ImageCropHandler;
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
     * Constructor.
     *
     * @param ImageCropHandler $imageCropHandler
     */
    public function __construct(ImageCropHandler $imageCropHandler)
    {
        $this->imageCropHandler = $imageCropHandler;
    }

    public function cropAction(Request $request)
    {
        $coordinates = $request->get('coordinates', null);
        $filename = $request->get('filename', null);

        if (!$filename || (null === $coordinates)) {
            throw new NotFoundHttpException('Invalid coordinates or filename request parameters!');
        }

        return new JsonResponse($this->imageCropHandler->process($coordinates, $filename));
    }
}
