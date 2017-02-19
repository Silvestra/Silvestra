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
interface PriorityStrategyInterface
{

    /**
     * Increase node priority.
     *
     * @param NodeInterface $node
     */
    public function increase(NodeInterface $node);

    /**
     * Get priority strategy name.
     *
     * @return string
     */
    public function getName();
}
