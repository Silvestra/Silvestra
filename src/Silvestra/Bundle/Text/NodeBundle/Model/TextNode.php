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

class TextNode implements TextNodeInterface
{

    /**
     * @var TextInterface
     */
    protected $text;

    /**
     * @var NodeInterface
     */
    protected $node;

    /**
     * {@inheritdoc}
     */
    public function setText(TextInterface $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritdoc}
     */
    public function setNode(NodeInterface $node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNode()
    {
        return $this->node;
    }
}
