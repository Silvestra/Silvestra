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

use Symfony\Component\Translation\TranslatorInterface;
use Tadcka\Component\Tree\Model\Manager\NodeTranslationManagerInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;
use Silvestra\Bundle\NodeBundle\Provider\SitemapProviderInterface;
use Silvestra\Bundle\NodeBundle\TadckaSitemapBundle;
use Tadcka\Component\Tree\Provider\NodeProviderInterface;
use Tadcka\Component\Tree\Provider\TreeProviderInterface;
use Tadcka\JsTreeBundle\Model\Node;
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 5/23/14 12:44 AM
 */
class TreeHelper
{
    /**
     * @var NodeProviderInterface
     */
    private $nodeProvider;

    /**
     * @var NodeTranslationManagerInterface
     */
    private $nodeTranslationManager;

    /**
     * @var SitemapProviderInterface
     */
    private $sitemapProvider;

    /**
     * @var TreeProviderInterface
     */
    private $treeProvider;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param NodeTranslationManagerInterface $nodeTranslationManager
     * @param NodeProviderInterface $nodeProvider
     * @param SitemapProviderInterface $sitemapProvider
     * @param TranslatorInterface $translator
     * @param TreeProviderInterface $treeProvider
     */
    public function __construct(
        NodeProviderInterface $nodeProvider,
        NodeTranslationManagerInterface $nodeTranslationManager,
        SitemapProviderInterface $sitemapProvider,
        TranslatorInterface $translator,
        TreeProviderInterface $treeProvider
    ) {
        $this->nodeProvider = $nodeProvider;
        $this->nodeTranslationManager = $nodeTranslationManager;
        $this->sitemapProvider = $sitemapProvider;
        $this->translator = $translator;
        $this->treeProvider = $treeProvider;
    }

    /**
     * Get frontend root node.
     *
     * @param string $locale
     *
     * @return Node
     */
    public function getRootNode($locale)
    {
        $rootNode = $this->sitemapProvider->getRootNode();
        $translation = $rootNode->getTranslation($locale);

        if (null === $translation) {
            $translation = $this->createBackendNodeTranslation($rootNode, $this->getTitle($rootNode, $locale), $locale);

            $rootNode->addTranslation($translation);
            $this->nodeTranslationManager->save();
        }

        return $this->createFrontendNode(
            $rootNode,
            $translation->getTitle(),
            $this->hasChildren($rootNode),
            $this->getIcon($rootNode)
        );
    }

    /**
     * Get frontend node.
     *
     * @param NodeInterface $node
     * @param string $locale
     *
     * @return Node
     */
    public function getNode(NodeInterface $node, $locale)
    {
        return $this->createFrontendNode(
            $node,
            $this->getTitle($node, $locale),
            count($node->getChildren()) > 0,
            $this->getIcon($node)
        );
    }

    /**
     * Get frontend node children.
     *
     * @param NodeInterface $node
     * @param string $locale
     *
     * @return array|Node[]
     */
    public function getChildren(NodeInterface $node, $locale)
    {
        return $this->createFrontendNodeChildren($node, $locale);
    }

    /**
     * Create frontend node.
     *
     * @param NodeInterface $node
     * @param string $title
     * @param bool|array|Node[] $children
     * @param string $icon
     *
     * @return Node
     */
    private function createFrontendNode(NodeInterface $node, $title, $children, $icon)
    {
        return new Node($node->getId(), $title, $children, $icon);
    }

    /**
     * Create frontend node children.
     *
     * @param NodeInterface $node
     * @param string $locale
     *
     * @return array|Node[]
     */
    private function createFrontendNodeChildren(NodeInterface $node, $locale)
    {
        $children = array();

        /** @var NodeInterface $child */
        foreach ($node->getChildren() as $child) {
            $children[] = $this->createFrontendNode(
                $child,
                $this->getTitle($child, $locale),
                $this->hasChildren($child),
                $this->getIcon($child)
            );
        }

        return $children;
    }

    /**
     * Create backend node translation.
     *
     * @param NodeInterface $node
     * @param string $title
     * @param string $locale
     *
     * @return NodeTranslationInterface
     */
    private function createBackendNodeTranslation(NodeInterface $node, $title, $locale)
    {
        $translation = $this->nodeTranslationManager->create();

        $translation->setLang($locale);
        $translation->setNode($node);
        $translation->setTitle($title);
        $this->nodeTranslationManager->add($translation);

        return $translation;
    }

    /**
     * Get node title.
     *
     * @param NodeInterface $node
     * @param string $locale
     *
     * @return string
     */
    private function getTitle(NodeInterface $node, $locale)
    {
        if ((null === $node->getParent()) && (null === $node->getTranslation($locale))) {
            return $this->getRootNodeTitle();
        }

        $translation = $node->getTranslation($locale);

        if (null !== $translation && $title = trim($translation->getTitle())) {
            return $title;
        }

        return $this->translator->trans('not_found_title', array(), 'TadckaSitemapBundle');
    }

    /**
     * Get root node title.
     *
     * @return string
     */
    private function getRootNodeTitle()
    {
        $config = $this->treeProvider->getTreeConfig(TadckaSitemapBundle::SITEMAP_TREE);

        $title = $config->getName();
        if ($config->getTranslationDomain()) {
            $title = $this->translator->trans($config->getName(), array(), $config->getTranslationDomain());
        }

        return $title;
    }

    /**
     * Has node children.
     *
     * @param NodeInterface $node
     *
     * @return bool
     */
    private function hasChildren(NodeInterface $node)
    {
        return count($node->getChildren()) ? true : false;
    }

    /**
     * Get node icon.
     *
     * @param NodeInterface $node
     *
     * @return null|string
     */
    private function getIcon(NodeInterface $node)
    {
        if (null === $node->getParent()) {
            return $this->getRootNodeIcon();
        }

        if ($node->getType() && (null !== $config = $this->nodeProvider->getNodeTypeConfig($node->getType()))) {
            return $config->getIconPath();
        }

        return null;
    }

    /**
     * Get root node icon.
     *
     * @return null|string
     */
    private function getRootNodeIcon()
    {
        $config = $this->treeProvider->getTreeConfig(TadckaSitemapBundle::SITEMAP_TREE);
        if (null !== $config) {
            return $config->getIconPath();
        }

        return null;
    }
}
