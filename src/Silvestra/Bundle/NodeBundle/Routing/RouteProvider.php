<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Routing;

use Tadcka\Component\Routing\Model\Manager\RouteManagerInterface;
use Tadcka\Component\Routing\Model\RouteInterface;
use Silvestra\Bundle\NodeBundle\Exception\RouteException;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/1/14 4:07 PM
 */
class RouteProvider
{
    /**
     * @var RouteManagerInterface
     */
    private $routeManager;

    /**
     * Constructor.
     *
     * @param RouteManagerInterface $routeManager
     */
    public function __construct(RouteManagerInterface $routeManager)
    {
        $this->routeManager = $routeManager;
    }

    /**
     * Get route by pattern.
     *
     * @param string $pattern
     *
     * @return null|RouteInterface
     */
    public function getRouteByPattern($pattern)
    {
        return $this->routeManager->findByRoutePattern($pattern);
    }

    /**
     * Get route name.
     *
     * @param NodeInterface $node
     * @param null|string $locale
     *
     * @return string
     *
     * @throws RouteException
     */
    public function getRouteName(NodeInterface $node, $locale = null)
    {
        if (!$node->getId()) {
            throw new RouteException('Node id cannot be empty!');
        }

        $name = NodeTranslationInterface::OBJECT_TYPE . '_' . $node->getId();
        if (null !== $locale) {
            $name .= '_' . $locale;
        }

        return $name;
    }
}
