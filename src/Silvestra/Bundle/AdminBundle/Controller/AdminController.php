<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\AdminBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends ContainerAware
{
    public function indexAction()
    {
        return $this->renderResponse('SilvestraAdminBundle:Admin:index.html.twig');
    }

    /**
     * Render response.
     *
     * @param string $name
     * @param array $parameters
     *
     * @return Response
     */
    protected function renderResponse($name, array $parameters = array())
    {
        return new Response($this->container->get('templating')->render($name, $parameters));
    }
}
