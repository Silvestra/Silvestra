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
use Tadcka\Component\Tree\Model\NodeTranslationInterface;
use Silvestra\Bundle\NodeBundle\Routing\RouterHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.10.23 16.49
 */
class NodeRouteNotEmptyValidator extends ConstraintValidator
{
    /**
     * @var RouterHelper
     */
    private $routeHelper;

    /**
     * Constructor.
     *
     * @param RouterHelper $routeHelper
     */
    public function __construct(RouterHelper $routeHelper)
    {
        $this->routeHelper = $routeHelper;
    }

    /**
     * Checks if the passed node is valid.
     *
     * @param NodeTranslationInterface $nodeTranslation
     * @param Constraint|NodeRouteNotEmpty $constraint
     */
    public function validate($nodeTranslation, Constraint $constraint)
    {
        if (false === $this->routeHelper->hasRoute($nodeTranslation->getLang(), $nodeTranslation->getNode())) {
            $this->context->addViolation($constraint->message, array('%locale%' => $nodeTranslation->getLang()));
        }
    }
}
