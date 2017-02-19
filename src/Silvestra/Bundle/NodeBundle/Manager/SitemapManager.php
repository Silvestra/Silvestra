<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Manager;

use Silvestra\Component\Seo\Model\Manager\SeoMetadataManagerInterface;
use Silvestra\Bundle\NodeBundle\Factory\RouteFactory;
use Silvestra\Bundle\NodeBundle\Factory\SeoFactory;
use Silvestra\Bundle\NodeBundle\Priority\StrategyRegistry;
use Silvestra\Bundle\NodeBundle\Routing\RedirectRoute;
use Silvestra\Bundle\NodeBundle\Routing\RouterHelper;
use Tadcka\Component\Routing\Model\Manager\RedirectRouteManagerInterface;
use Tadcka\Component\Routing\Model\Manager\RouteManager;
use Tadcka\Component\Routing\Model\RouteInterface;
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/22/15 8:26 PM
 */
class SitemapManager
{

    /**
     * @var string
     */
    private $priorityStrategy;

    /**
     * @var StrategyRegistry
     */
    private $priorityStrategyRegistry;

    /**
     * @var RedirectRouteManagerInterface
     */
    private $redirectRouteManager;

    /**
     * @var RouteFactory
     */
    private $routeFactory;

    /**
     * @var RouteManager
     */
    private $routeManager;

    /**
     * @var RouterHelper
     */
    private $routerHelper;

    /**
     * @var SeoFactory
     */
    private $seoFactory;

    /**
     * @var SeoMetadataManagerInterface
     */
    private $seoMetadataManager;

    /**
     * Constructor.
     *
     * @param string $priorityStrategy
     * @param StrategyRegistry $priorityStrategyRegistry
     * @param RedirectRouteManagerInterface $redirectRouteManager
     * @param RouteFactory $routeFactory
     * @param RouteManager $routeManager
     * @param RouterHelper $routerHelper
     * @param SeoFactory $seoFactory
     * @param SeoMetadataManagerInterface $seoMetadataManager
     */
    public function __construct(
        $priorityStrategy,
        StrategyRegistry $priorityStrategyRegistry,
        RedirectRouteManagerInterface $redirectRouteManager,
        RouteFactory $routeFactory,
        RouteManager $routeManager,
        RouterHelper $routerHelper,
        SeoFactory $seoFactory,
        SeoMetadataManagerInterface $seoMetadataManager
    ) {
        $this->priorityStrategy = $priorityStrategy;
        $this->priorityStrategyRegistry = $priorityStrategyRegistry;
        $this->redirectRouteManager = $redirectRouteManager;
        $this->routeFactory = $routeFactory;
        $this->routeManager = $routeManager;
        $this->routerHelper = $routerHelper;
        $this->seoFactory = $seoFactory;
        $this->seoMetadataManager = $seoMetadataManager;
    }

    /**
     * On create sitemap node.
     *
     * @param NodeInterface $node
     */
    public function onCreateNode(NodeInterface $node)
    {
        if ($this->routerHelper->hasController($node->getType())) {
            foreach ($node->getTranslations() as $translation) {
                $route = $this->routeFactory->create($translation);
                $seoMetadata = $this->seoFactory->create($translation);

                $translation->setRoute($route);
                $translation->setSeoMetadata($seoMetadata);
            }
        }

        if (null !== $this->priorityStrategy) {
            $this->priorityStrategyRegistry->get($this->priorityStrategy)->increase($node);
        }
    }

    /**
     * On delete sitemap node.
     *
     * @param NodeInterface $node
     */
    public function onDeleteNode(NodeInterface $node)
    {
        foreach ($node->getTranslations() as $translation) {
            if (null !== $route = $translation->getRoute()) {
                $this->deleteNodeRoute($node, $route);
            }

            if (null !== $seoMetadata = $translation->getSeoMetadata()) {
                $this->seoMetadataManager->remove($seoMetadata);
            }
        }
    }

    /**
     * Delete node route.
     *
     * @param NodeInterface $node
     * @param RouteInterface $route
     */
    private function deleteNodeRoute(NodeInterface $node, RouteInterface $route)
    {
        $this->routeManager->remove($route);

        $redirectRouteName = $route->getDefault('redirectRouteName');
        if (RedirectRoute::NODE_TYPE === $node->getType() && (null !== $redirectRouteName)) {
            $redirectRoute = $this->redirectRouteManager->findByName($redirectRouteName);
            if (null !== $redirectRoute) {
                $this->redirectRouteManager->remove($redirectRoute);
            }
        }
    }
}
