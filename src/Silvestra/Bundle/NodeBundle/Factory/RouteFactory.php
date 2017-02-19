<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Factory;

use Silvestra\Bundle\NodeBundle\Routing\RouteGenerator;
use Silvestra\Bundle\NodeBundle\Routing\RouterHelper;
use Tadcka\Component\Routing\Model\Manager\RouteManagerInterface;
use Tadcka\Component\Routing\Model\RouteInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/22/15 8:09 PM
 */
class RouteFactory
{

    /**
     * @var RouteGenerator
     */
    private $routeGenerator;

    /**
     * @var RouteManagerInterface
     */
    private $routeManager;

    /**
     * @var RouterHelper
     */
    private $routerHelper;

    /**
     * Constructor.
     *
     * @param RouteGenerator $routeGenerator
     * @param RouteManagerInterface $routeManager
     * @param RouterHelper $routerHelper
     */
    public function __construct(
        RouteGenerator $routeGenerator,
        RouteManagerInterface $routeManager,
        RouterHelper $routerHelper
    ) {
        $this->routeGenerator = $routeGenerator;
        $this->routeManager = $routeManager;
        $this->routerHelper = $routerHelper;
    }

    /**
     * Create node translation route.
     *
     * @param NodeTranslationInterface $translation
     *
     * @return RouteInterface
     */
    public function create(NodeTranslationInterface $translation)
    {
        $locale = $translation->getLang();
        $node = $translation->getNode();
        $route = $this->routeManager->create();

        $route->setRoutePattern($this->routerHelper->getRoutePattern($translation->getTitle(), $node, $locale));
        $this->routeGenerator->generateRoute($route, $node, $locale);

        $this->routeManager->add($route);

        return $route;
    }
}
