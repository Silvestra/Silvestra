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
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/11/14 9:27 PM
 */
class ImageController extends ContainerAware
{
    public function indexAction()
    {
        $builder = $this->container->get('form.factory')->createBuilder();

        $builder->add('images1', 'silvestra_media_gallery');
        $builder->add('images2', 'silvestra_media_gallery');
        $builder->add('image1', 'silvestra_media_image');
        $builder->add('image2', 'silvestra_media_image');

        $form = $builder->getForm();

        return $this->renderResponse(
            'SilvestraMediaBundle:Image:index.html.twig',
            array(
                'form' => $form->createView(),
                'page_header' => 'Test',
            )
        );
    }

    public function uploadAction(Request $request)
    {

    }

    public function cropAction(Request $request)
    {

    }

    /**
     * Render response.
     *
     * @param string $name
     * @param array $parameters
     *
     * @return Response
     */
    private function renderResponse($name, array $parameters = array())
    {
        return new Response($this->container->get('templating')->render($name, $parameters));
    }
}
