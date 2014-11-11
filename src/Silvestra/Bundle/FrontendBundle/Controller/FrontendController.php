<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\FrontendBundle\Controller;

use Silvestra\Component\Seo\SeoPresentationInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;
use Tadcka\Bundle\SitemapBundle\Provider\PageNodeProviderInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/7/14 1:00 PM
 */
abstract class FrontendController extends ContainerAware
{
    /**
     * Get page provider.
     *
     * @return PageNodeProviderInterface
     */
    private function getPageNodeProvider()
    {
        return $this->container->get('tadcka_sitemap.provider.page_node');
    }

    /**
     * Get router.
     *
     * @return RouterInterface
     */
    protected function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * Get page node or 404.
     *
     * @param Request $request
     *
     * @return NodeInterface
     */
    protected function getPageNodeOr404(Request $request)
    {
        return $this->getPageNodeProvider()->getNodeOr404($request);
    }

    /**
     * Get page node translation or 404.
     *
     * @param Request $request
     *
     * @return NodeTranslationInterface
     */
    protected function getPageNodeTranslationOr404(Request $request)
    {
        return $this->getPageNodeProvider()->getNodeTranslationOr404($request);
    }

    /**
     * Get seo page presentation.
     *
     * @return SeoPresentationInterface
     */
    protected function getSeoPresentation()
    {
        return $this->container->get('silvestra_seo.page.presentation');
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

    /**
     * Get config.
     *
     * @return array
     */
    protected function getConfig()
    {
        $config = $this->container->getParameter('silvestra_frontend.controllers');

        return $config[$this->getName()];
    }

    /**
     * Get controller name.
     *
     * @return string
     */
    abstract protected function getName();
}
