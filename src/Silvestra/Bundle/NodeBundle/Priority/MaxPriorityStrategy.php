<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Priority;

use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/21/15 12:12 AM
 */
class MaxPriorityStrategy implements PriorityStrategyInterface
{

    /**
     * {@inheritdoc}
     */
    public function increase(NodeInterface $node)
    {
        $node->setPriority(1 + $this->getMaxPriority($node->getParent()));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'max_priority';
    }

    /**
     * Get max priority.
     *
     * @param NodeInterface $parent
     *
     * @return int
     */
    private function getMaxPriority(NodeInterface $parent)
    {
        $priority = 0;
        foreach ($parent->getChildren() as $child) {
            $priority = max($priority, $child->getPriority());
        }

        return $priority;
    }
}
