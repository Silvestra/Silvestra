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

use Silvestra\Component\Seo\Model\SeoMetadataInterface;
use Silvestra\Component\Seo\SeoPresentationInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;
use Tadcka\Bundle\SitemapBundle\Provider\PageNodeProviderInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/7/14 1:00 PM
 *
 * @deprecated
 */
abstract class FrontendController
{
    /**
     * @var array
     */
    private $controllers;

    /**
     * @var PageNodeProviderInterface
     */
    private $pageNodeProvider;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var SeoPresentationInterface
     */
    private $seoPresentation;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @param array $controllers
     */
    public function setControllers(array $controllers)
    {
        $this->controllers = $controllers;
    }

    /**
     * @param PageNodeProviderInterface $pageNodeProvider
     */
    public function setPageNodeProvider(PageNodeProviderInterface $pageNodeProvider)
    {
        $this->pageNodeProvider = $pageNodeProvider;
    }

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param SeoPresentationInterface $seoPresentation
     */
    public function setSeoPresentation(SeoPresentationInterface $seoPresentation)
    {
        $this->seoPresentation = $seoPresentation;
    }

    /**
     * @param EngineInterface $templating
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
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
        return $this->pageNodeProvider->getNodeOr404($request);
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
        return $this->pageNodeProvider->getNodeTranslationOr404($request);
    }

    /**
     * Generate url.
     *
     * @param string $name
     * @param array $parameters
     * @param bool $referenceType
     *
     * @return string
     */
    protected function generateUrl($name, $parameters = array(), $referenceType = RouterInterface::ABSOLUTE_PATH)
    {
        return $this->router->generate($name, $parameters, $referenceType);
    }

    /**
     * Update page seo.
     *
     * @param SeoMetadataInterface $seoMetadata
     */
    protected function updatePageSeo(SeoMetadataInterface $seoMetadata)
    {
        return $this->seoPresentation->updateSeoPage($seoMetadata);
    }

    /**
     * Render.
     *
     * @param string $name
     * @param array $parameters
     *
     * @return string
     */
    protected function render($name, array $parameters = array())
    {
        return $this->templating->render($name, $parameters);
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
        return new Response($this->templating->render($name, $parameters));
    }

    /**
     * Get config.
     *
     * @return array
     */
    protected function getConfig()
    {
        return $this->controllers[$this->getName()];
    }

    /**
     * Get controller name.
     *
     * @return string
     */
    abstract protected function getName();
}
