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
use Tadcka\Component\Tree\Model\NodeTranslationInterface;
use Silvestra\Bundle\NodeBundle\Routing\RouteGenerator;
use Tadcka\Component\Routing\Model\Manager\RedirectRouteManagerInterface;
use Tadcka\Component\Routing\Model\Manager\RouteManagerInterface;
use Tadcka\Component\Routing\Model\RedirectRouteInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/4/14 9:26 PM
 */
class NodeI18nRedirectRouteTransformer implements DataTransformerInterface
{
    /**
     * @var RedirectRouteInterface
     */
    private $redirectRoute;

    /**
     * @var RedirectRouteManagerInterface
     */
    private $redirectRouteManager;

    /**
     * @var RouteGenerator
     */
    private $routeGenerator;

    /**
     * @var RouteManagerInterface
     */
    private $routeManager;

    /**
     * Constructor.
     *
     * @param RedirectRouteManagerInterface $redirectRouteManager
     * @param RouteGenerator $routeGenerator
     * @param RouteManagerInterface $routeManager
     */
    public function __construct(
        RedirectRouteManagerInterface $redirectRouteManager,
        RouteGenerator $routeGenerator,
        RouteManagerInterface $routeManager
    ) {
        $this->redirectRouteManager = $redirectRouteManager;
        $this->routeGenerator = $routeGenerator;
        $this->routeManager = $routeManager;
    }

    /**
     * Set redirect route.
     *
     * @param RedirectRouteInterface $redirectRoute
     *
     * @return NodeI18nRedirectRouteTransformer
     */
    public function setRedirectRoute($redirectRoute)
    {
        $this->redirectRoute = $redirectRoute;

        return $this;
    }

    /**
     * Get redirect route.
     *
     * @param string $redirectRouteName
     *
     * @return RedirectRouteInterface
     */
    public function getRedirectRoute($redirectRouteName)
    {
        return $this->redirectRouteManager->findByName($redirectRouteName);
    }

    /**
     * Transform.
     *
     * @param NodeTranslationInterface $nodeTranslation
     *
     * @return NodeTranslationInterface
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

            if ('redirect' === $node->getType()) {
                $this->routeGenerator->generateRoute($route, $node, $nodeTranslation->getLang());
                $this->redirectRoute->setName($route->getName());
                $route->setDefault('redirectRouteName', $this->redirectRoute->getName());

                $this->routeManager->add($route);
                $this->redirectRouteManager->add($this->redirectRoute);
            } else {
                $this->routeManager->remove($route);
                $this->redirectRouteManager->remove($this->redirectRoute);
            }
        }

        return $nodeTranslation;
    }
}
