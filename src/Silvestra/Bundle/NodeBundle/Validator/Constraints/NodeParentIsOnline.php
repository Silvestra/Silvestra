<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.10.23 16.13
 */
class NodeParentIsOnline extends Constraint
{
    public $message = 'silvestra_node.node_parent_is_not_online';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'silvestra_node.node_parent_is_online';
    }
}
