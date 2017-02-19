<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\EventListener;

use Silvestra\Bundle\NodeBundle\Manager\SitemapManager;
use Silvestra\Bundle\NodeBundle\TadckaSitemapBundle;
use Tadcka\Component\Tree\Event\TreeNodeEvent;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  14.8.3 20.34
 */
class TreeNodeListener
{

    /**
     * @var SitemapManager
     */
    private $sitemapManager;

    /**
     * Constructor.
     *
     * @param SitemapManager $sitemapManager
     */
    public function __construct(SitemapManager $sitemapManager)
    {
        $this->sitemapManager = $sitemapManager;
    }

    /**
     * On sitemap node create.
     *
     * @param TreeNodeEvent $event
     */
    public function onSitemapNodeCreate(TreeNodeEvent $event)
    {
        $node = $event->getNode();
        if (TadckaSitemapBundle::SITEMAP_TREE === $node->getTree()->getSlug()) {
            $this->sitemapManager->onCreateNode($node);
        }
    }

    /**
     * On delete node.
     *
     * @param TreeNodeEvent $event
     */
    public function onSitemapNodeDelete(TreeNodeEvent $event)
    {
        $node = $event->getNode();
        if (TadckaSitemapBundle::SITEMAP_TREE === $node->getTree()->getSlug()) {
            $this->sitemapManager->onDeleteNode($node);
        }
    }
}
