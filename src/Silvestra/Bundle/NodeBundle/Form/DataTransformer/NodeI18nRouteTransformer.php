<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Tadcka\Component\Routing\Model\Manager\RouteManagerInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;
use Silvestra\Bundle\NodeBundle\Routing\RouteGenerator;
use Silvestra\Bundle\NodeBundle\Routing\RouterHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/26/14 8:44 PM
 */
class NodeI18nRouteTransformer implements DataTransformerInterface
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
     * {@inheritdoc}
     */
    public function transform($nodeTranslation)
    {
        return $nodeTranslation;
    }

    /**
     * Reverse transform.
     *
     * @param NodeTranslationInterface $nodeTranslation
     *
     * @return NodeTranslationInterface
     */
    public function reverseTransform($nodeTranslation)
    {
        $route = $nodeTranslation->getRoute();

        if (null !== $route && $route->getRoutePattern()) {
            $node = $nodeTranslation->getNode();

            if ($this->routerHelper->hasController($node->getType())) {
                $this->routeGenerator->generateRoute($route, $node, $nodeTranslation->getLang());

                $this->routeManager->add($route);
            } else {
                $this->routeManager->remove($route);
            }
        }

        return $nodeTranslation;
    }
}
