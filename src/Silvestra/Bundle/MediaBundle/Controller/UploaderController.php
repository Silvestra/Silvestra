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
use Silvestra\Component\Media\Handler\UploaderHandler;
use Silvestra\Component\Media\Image\ImageValidator;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UploaderController extends ContainerAware
{
    /**
     * @var ImageValidator
     */
    private $imageValidator;

    /**
     * @var UploaderHandler
     */
    private $uploaderHandler;

    /**
     * Constructor.
     *
     * @param ImageValidator $imageValidator
     * @param UploaderHandler $uploaderHandler
     */
    public function __construct(ImageValidator $imageValidator, UploaderHandler $uploaderHandler)
    {
        $this->imageValidator = $imageValidator;
        $this->uploaderHandler = $uploaderHandler;
    }

    public function uploadAction(Request $request)
    {
        $config = $request->get('config', array());

        if (!$this->imageValidator->validateConfig($config)) {
            throw new InvalidImageConfigException('Image config is not valid!');
        }

        $data = $this->uploaderHandler->process($request->files->get('image'), $config);

        return new JsonResponse($data);
    }
}
