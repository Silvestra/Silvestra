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

use Silvestra\Component\Media\Exception\InvalidImageConfigException;
use Silvestra\Component\Media\Handler\ImageUploadHandler;
use Silvestra\Component\Media\Handler\UploaderHandler;
use Silvestra\Component\Media\Image\Config\ImageConfigHelper;
use Silvestra\Component\Media\Image\ImageValidator;
use Silvestra\Component\Media\Token\TokenValidator;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageUploaderController extends ContainerAware
{
    /**
     * @var ImageValidator
     */
    private $imageValidator;

    /**
     * @var ImageUploadHandler
     */
    private $uploadHandler;

    /**
     * @var TokenValidator
     */
    private $tokenValidator;

    /**
     * Constructor.
     *
     * @param ImageValidator $imageValidator
     * @param ImageUploadHandler $uploadHandler
     * @param TokenValidator $tokenValidator
     */
    public function __construct(
        ImageValidator $imageValidator,
        ImageUploadHandler $uploadHandler,
        TokenValidator $tokenValidator
    ) {
        $this->imageValidator = $imageValidator;
        $this->uploadHandler = $uploadHandler;
        $this->tokenValidator = $tokenValidator;
    }

    public function uploadAction(Request $request)
    {
        $config = $request->get('config', array());

        if (false === $this->imageValidator->isConfigValid($config)) {
            throw new InvalidImageConfigException('Image config is not valid!');
        }

        $config = ImageConfigHelper::normalize($config);

        if (false === $this->tokenValidator->isValid($request->get('token'), $config)) {
            throw new NotFoundHttpException('Invalid upload token!');
        }

        return new JsonResponse($this->uploadHandler->process($request->files->get('image', null), $config));
    }
}
