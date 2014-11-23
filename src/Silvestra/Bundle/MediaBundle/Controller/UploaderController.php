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

use Silvestra\Component\Media\Handler\UploaderHandler;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UploaderController extends ContainerAware
{
    /**
     * @var UploaderHandler
     */
    private $uploaderHandler;

    /**
     * Constructor.
     *
     * @param UploaderHandler $uploaderHandler
     */
    public function __construct(UploaderHandler $uploaderHandler)
    {
        $this->uploaderHandler = $uploaderHandler;
    }

    public function uploadAction(Request $request)
    {
        $data = $this->uploaderHandler->process($request->files->get('image'), $request->get('config'));

        return new JsonResponse($data);
    }
}
