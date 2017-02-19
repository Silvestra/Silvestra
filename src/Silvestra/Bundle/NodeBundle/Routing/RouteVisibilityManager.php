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

use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/31/15 6:16 PM
 */
class RouteVisibilityManager
{
    /**
     * @var bool
     */
    private $recursiveInvisible;

    /**
     * Constructor.
     *
     * @param bool $recursiveInvisible
     */
    public function __construct($recursiveInvisible)
    {
        $this->recursiveInvisible = $recursiveInvisible;
    }

    /**
     * Set invisible route.
     *
     * @param string $locale
     * @param NodeInterface $node
     */
    public function setInvisible($locale, NodeInterface $node)
    {
        $translation = $node->getTranslation($locale);

        if ((null !== $translation) && (null !== $route = $translation->getRoute())) {
            $route->setVisible(false);
        }

        if ($this->recursiveInvisible) {
            foreach ($node->getChildren() as $child) {
                $this->setInvisible($locale, $child);
            }
        }
    }

    /**
     * Set visible route.
     *
     * @param string $locale
     * @param NodeInterface $node
     */
    public function setVisible($locale, NodeInterface $node)
    {
        $translation = $node->getTranslation($locale);

        if ((null !== $translation) && (null !== $route = $translation->getRoute())) {
            $route->setVisible(true);
        }
    }
}
