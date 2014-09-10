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

use Silvestra\Bundle\MediaBundle\Form\Factory\UploaderFormFactory;
use Silvestra\Bundle\MediaBundle\Form\Handler\UploaderFormHandler;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UploaderController extends ContainerAware
{
    public function indexAction(Request $request)
    {
        $form = $this->getFormFactory()->create(array());

        if ($this->getFormHandler()->process($request, $form)) {

        }

        return $this->renderResponse(
            'SilvestraMediaBundle:Uploader:index.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Get uploader form factory.
     *
     * @return UploaderFormFactory
     */
    private function getFormFactory()
    {
        return $this->container->get('silvestra_media.form_factory.uploader');
    }

    /**
     * Get uploader form handler.
     *
     * @return UploaderFormHandler
     */
    private function getFormHandler()
    {
        return $this->container->get('silvestra_media.form_handler.uploader');
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
