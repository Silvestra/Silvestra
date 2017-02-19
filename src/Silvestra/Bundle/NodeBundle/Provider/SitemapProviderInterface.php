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
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/3/14 10:51 AM
 */
interface SitemapProviderInterface
{
    /**
     * Get root node.
     *
     * @return NodeInterface
     *
     * @throws ResourceNotFoundException
     */
    public function getRootNode();
}
