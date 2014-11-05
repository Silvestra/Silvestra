<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\Text\NodeBundle\Model;

use Silvestra\Component\Text\Model\TextInterface;
use Tadcka\Component\Tree\Model\NodeInterface;

interface TextNodeInterface
{

    /**
     * Set text.
     *
     * @param TextInterface $text
     *
     * @return TextNodeInterface
     */
    public function setText(TextInterface $text);

    /**
     * Get text.
     *
     * @return TextInterface
     */
    public function getText();

    /**
     * Set node.
     *
     * @param NodeInterface $node
     *
     * @return TextNodeInterface
     */
    public function setNode(NodeInterface $node);

    /**
     * Get node.
     *
     * @return NodeInterface
     */
    public function getNode();
}
