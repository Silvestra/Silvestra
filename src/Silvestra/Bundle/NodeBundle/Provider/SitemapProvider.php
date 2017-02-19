<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Provider;

use Silvestra\Bundle\NodeBundle\Exception\ResourceNotFoundException;
use Silvestra\Bundle\NodeBundle\TadckaSitemapBundle;
use Tadcka\Component\Tree\Model\Manager\NodeManagerInterface;
use Tadcka\Component\Tree\Provider\TreeProviderInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/3/14 10:51 AM
 */
class SitemapProvider implements SitemapProviderInterface
{
    /**
     * @var NodeManagerInterface
     */
    private $nodeManager;

    /**
     * @var TreeProviderInterface
     */
    private $treeProvider;

    /**
     * Constructor.
     *
     * @param NodeManagerInterface $nodeManager
     * @param TreeProviderInterface $treeProvider
     */
    public function __construct(NodeManagerInterface $nodeManager, TreeProviderInterface $treeProvider)
    {
        $this->nodeManager = $nodeManager;
        $this->treeProvider = $treeProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getRootNode()
    {
        $tree = $this->treeProvider->getTree(TadckaSitemapBundle::SITEMAP_TREE);
        if (null === $tree) {
            throw new ResourceNotFoundException(sprintf('Tree %s not found', TadckaSitemapBundle::SITEMAP_TREE));
        }

        $rootNode = $this->nodeManager->findRootNode($tree);

        if (null === $rootNode) {
            $rootNode = $this->nodeManager->create();

            $rootNode->setTree($tree);
            $this->nodeManager->add($rootNode);
        }

        return $rootNode;
    }
}
