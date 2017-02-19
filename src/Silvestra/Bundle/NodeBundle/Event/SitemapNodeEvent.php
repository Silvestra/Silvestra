<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Silvestra\Bundle\NodeBundle\Frontend\Model\Tab;
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 6/24/14 11:42 AM
 */
class SitemapNodeEvent extends Event
{
    /**
     * @var NodeInterface
     */
    private $node;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var array|Tab[]
     */
    private $tabs = array();

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param NodeInterface $node
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     */
    public function __construct(NodeInterface $node, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->node = $node;
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * Get node.
     *
     * @return NodeInterface
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Get router.
     *
     * @return RouterInterface
     *
     * @deprecated
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Get tabs.
     *
     * @return array|Tab[]
     */
    public function getTabs()
    {
        $this->sort();

        return $this->tabs;
    }

    /**
     * Add tab.
     *
     * @param Tab $tab
     */
    public function addTab(Tab $tab)
    {
        $this->tabs[$tab->getSlug()] = $tab;
    }

    /**
     * Get translator.
     *
     * @return TranslatorInterface
     *
     * @deprecated
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * Sort all tabs.
     */
    private function sort()
    {
        uasort(
            $this->tabs,
            function (Tab $first, Tab $second) {
                if ($first->getPriority() <= $second->getPriority()) {
                    return 1;
                }

                if ($first->getPriority() > $second->getPriority()) {
                    return -1;
                }

                return 0;
            }
        );
    }
}
