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

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UploaderController extends ContainerAware
{
    public function uploadAction(Request $request)
    {
        $config = json_decode($request->get('config'), true);
        $files = $request->files->get('files');
        $uploaderHandler = $this->getUploaderHandler();
        $data = array();
        foreach ($files as $file) {
            $data[] = $uploaderHandler->process($file, $config['uploaderConfig']);
        }

        return new JsonResponse($data);
    }


    private function getUploaderHandler()
    {
        return $this->container->get('silvestra_media.uploader_handler');
    }
}
