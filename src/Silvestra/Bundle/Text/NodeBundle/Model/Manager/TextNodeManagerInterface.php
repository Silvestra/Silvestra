<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\Text\NodeBundle\Model\Manager;

use Tadcka\Bundle\SitemapBundle\Model\NodeInterface;
use Silvestra\Bundle\Text\NodeBundle\Model\TextNodeInterface;

interface TextNodeManagerInterface
{
    /**
     * Find text node by node.
     *
     * @param NodeInterface $node
     *
     * @return null|TextNodeInterface
     */
    public function findTextNodeByNode(NodeInterface $node);

    /**
     * Create new TextNode object.
     *
     * @return TextNodeInterface
     */
    public function create();

    /**
     * Add TextNode object from persistent layer.
     *
     * @param TextNodeInterface $textNode
     * @param bool $save
     */
    public function add(TextNodeInterface $textNode, $save = false);

    /**
     * Remove TextNode object from persistent layer.
     *
     * @param TextNodeInterface $textNode
     * @param bool $save
     */
    public function remove(TextNodeInterface $textNode, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear TextNode objects from persistent layer.
     */
    public function clear();

    /**
     * Get TextNode object class name.
     *
     * @return string
     */
    public function getClass();
}
