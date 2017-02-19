<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Frontend;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Silvestra\Bundle\NodeBundle\Frontend\Model\Tab;
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/22/15 9:07 PM
 */
class TabFactory
{

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     */
    public function __construct(RouterInterface $router, TranslatorInterface $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * Create menu tab.
     *
     * @param NodeInterface $node
     *
     * @return Tab
     */
    public function createMenuTab(NodeInterface $node)
    {
        return new Tab(
            $this->translator->trans('node.menu', array(), 'TadckaSitemapBundle'),
            'node_menu',
            $this->router->generate(
                'silvestra_node_tree_edit_node',
                array('_format' => 'json', 'nodeId' => $node->getId())
            ),
            250
        );
    }

    /**
     * Create redirect route tab.
     *
     * @param NodeInterface $node
     *
     * @return Tab
     */
    public function createRedirectRouteTab(NodeInterface $node)
    {
        return new Tab(
            $this->translator->trans('redirect', array(), 'TadckaSitemapBundle'),
            'node_route',
            $this->router->generate(
                'silvestra_node_node_redirect_route',
                array('_format' => 'json', 'nodeId' => $node->getId())
            ),
            200
        );
    }

    /**
     * Create route tab.
     *
     * @param NodeInterface $node
     *
     * @return Tab
     */
    public function createRouteTab(NodeInterface $node)
    {
        return new Tab(
            $this->translator->trans('node.route', array(), 'TadckaSitemapBundle'),
            'node_route',
            $this->router->generate(
                'silvestra_node_node_route',
                array('_format' => 'json', 'nodeId' => $node->getId())
            ),
            200
        );
    }

    /**
     * Create seo tab.
     *
     * @param NodeInterface $node
     *
     * @return Tab
     */
    public function createSeoTab(NodeInterface $node)
    {
        return new Tab(
            $this->translator->trans('node.seo', array(), 'TadckaSitemapBundle'),
            'node_seo',
            $this->router->generate(
                'silvestra_node_seo',
                array('_format' => 'json', 'nodeId' => $node->getId())
            ),
            150
        );
    }
}
