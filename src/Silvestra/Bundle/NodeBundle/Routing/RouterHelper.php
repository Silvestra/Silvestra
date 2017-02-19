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

use Ferrandini\Urlizer;
use Silvestra\Bundle\NodeBundle\Exception\RouteException;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/1/14 4:37 PM
 */
class RouterHelper
{
    /**
     * @var bool
     */
    private $multiLanguageEnabled;

    /**
     * @var array
     */
    private $multiLanguageLocales;

    /**
     * @var array
     */
    private $controllers;

    /**
     * @var string
     */
    private $strategy;

    /**
     * Constructor.
     *
     * @param array $controllers
     * @param bool $multiLanguageEnabled
     * @param array $multiLanguageLocales
     * @param string $strategy
     */
    public function __construct(array $controllers, $multiLanguageEnabled, array $multiLanguageLocales, $strategy)
    {
        $this->controllers = $controllers;
        $this->multiLanguageEnabled = $multiLanguageEnabled;
        $this->multiLanguageLocales = $multiLanguageLocales;
        $this->strategy = $strategy;
    }

    /**
     * Get route controller.
     *
     * @param string $nodeType
     *
     * @return string
     *
     * @throws RouteException
     */
    public function getRouteController($nodeType)
    {
        if ($this->hasController($nodeType)) {
            return $this->controllers[$nodeType];
        }

        throw new RouteException(sprintf('%s node type don\'t have controller', $nodeType));
    }

    /**
     * Get route pattern.
     *
     * @param string $pattern
     * @param string $locale
     * @param NodeInterface $node
     *
     * @return string
     *
     * @throws RouteException
     */
    public function getRoutePattern($pattern, NodeInterface $node, $locale)
    {
        if (false === $this->hasController($node->getType())) {
            throw new RouteException(sprintf('Node type %s don\'t have controller!', $node->getType()));
        }

        if (!trim($pattern)) {
            throw new RouteException('Pattern cannot be empty!');
        }

        $parent = $node->getParent();
        $routePattern = $this->normalizeRoutePattern($pattern);
        if ((RouteGenerator::STRATEGY_FULL_PATH === $this->strategy) && (null !== $parent)) {
            $routePattern = $this->getRouteFullPath($parent, $locale) . '/' . ltrim($routePattern, '/');
        }

        return $routePattern;
    }

    /**
     * Check if node has route.
     *
     * @param string $locale
     * @param NodeInterface $node
     *
     * @return bool
     */
    public function hasRoute($locale, NodeInterface $node)
    {
        /** @var NodeTranslationInterface $translation */
        $translation = $node->getTranslation($locale);

        return (null !== $translation) && (null !== $translation->getRoute())
            && $translation->getRoute()->getRoutePattern();
    }

    /**
     * Check if route has controller.
     *
     * @param string $nodeType
     *
     * @return bool
     */
    public function hasController($nodeType)
    {
        return isset($this->controllers[$nodeType]);
    }

    /**
     * Multi language is enabled.
     *
     * @return bool
     */
    public function multiLanguageIsEnabled()
    {
        return $this->multiLanguageEnabled;
    }

    /**
     * Get multi language locales.
     *
     * @return array
     */
    public function getMultiLanguageLocales()
    {
        return $this->multiLanguageLocales;
    }

    /**
     * Normalize route pattern.
     *
     * @param string $pattern
     *
     * @return string
     */
    public function normalizeRoutePattern($pattern)
    {
        $data = explode('/', $pattern);

        $result = '';
        foreach ($data as $string) {
            if (trim($string)) {
                $result .= '/' . Urlizer::urlize($string);
            }
        }

        return $result;
    }

    /**
     * Get route full path.
     *
     * @param NodeInterface $node
     * @param string $locale
     *
     * @return string
     */
    private function getRouteFullPath(NodeInterface $node, $locale)
    {
        $path = '';

        if ($this->hasController($node->getType())) {
            $parent = $node->getParent();

            if ((null !== $parent) && $this->hasController($parent->getType())) {
                $path = $this->getRouteFullPath($parent, $locale);
            }

            if (null !== $translation = $node->getTranslation($locale)) {
                $path .= $this->normalizeRoutePattern($translation->getTitle());
            }
        }

        return $path;
    }
}
