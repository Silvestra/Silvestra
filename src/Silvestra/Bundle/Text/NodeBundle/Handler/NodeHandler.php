<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\Text\NodeBundle\Handler;

use Silvestra\Bundle\Text\NodeBundle\Model\Manager\TextNodeManagerInterface;
use Silvestra\Component\Text\Model\Manager\TextManagerInterface;
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class NodeHandler
{

    /**
     * @var TextManagerInterface
     */
    private $textManager;

    /**
     * @var TextNodeManagerInterface
     */
    private $textNodeManager;

    /**
     * Constructor.
     *
     * @param TextManagerInterface $textManager
     * @param TextNodeManagerInterface $textNodeManager
     */
    public function __construct(TextManagerInterface $textManager, TextNodeManagerInterface $textNodeManager)
    {
        $this->textManager = $textManager;
        $this->textNodeManager = $textNodeManager;
    }

    /**
     * On delete node.
     *
     * @param NodeInterface $node
     */
    public function onDeleteNode(NodeInterface $node)
    {
        $textNode = $this->textNodeManager->findTextNodeByNode($node);

        if (null !== $textNode) {
            $this->textNodeManager->remove($textNode);
            $this->textManager->remove($textNode->getText());
        }
    }
}
