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
use Symfony\Component\Validator\ConstraintValidator;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Provider\NodeProviderInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 6/26/14 10:27 PM
 */
class NodeTypeValidator extends ConstraintValidator
{
    /**
     * @var NodeProviderInterface
     */
    private $nodeProvider;

    /**
     * Constructor.
     *
     * @param NodeProviderInterface $nodeProvider
     */
    public function __construct(NodeProviderInterface $nodeProvider)
    {
        $this->nodeProvider = $nodeProvider;
    }

    /**
     * Checks if the passed node type is valid.
     *
     * @param NodeInterface $node
     * @param Constraint $constraint
     */
    public function validate($node, Constraint $constraint)
    {
        if (!in_array($node->getType(), $this->nodeProvider->getActiveNodeTypes($node))) {
            $nodeTypeName = $node->getType();
            if (null !== $config = $this->nodeProvider->getNodeTypeConfig($node->getType())) {
                $nodeTypeName = $config->getName();
            }
            $this->context->addViolation($constraint->message, array('%node_type%' => $nodeTypeName));
        }
    }
}
