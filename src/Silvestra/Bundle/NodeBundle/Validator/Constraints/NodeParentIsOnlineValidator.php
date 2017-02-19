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
use Tadcka\Component\Tree\Model\NodeTranslationInterface;
use Silvestra\Bundle\NodeBundle\Routing\RouterHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.10.23 16.20
 */
class NodeParentIsOnlineValidator extends ConstraintValidator
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
     * @param Constraint|NodeParentIsOnline $constraint
     */
    public function validate($nodeTranslation, Constraint $constraint)
    {
        $route = $nodeTranslation->getRoute();
        $parentIsOnline = $this->parentIsOnline($nodeTranslation->getNode(), $nodeTranslation->getLang());

        if ((null !== $route) && $route->isVisible() && (false === $parentIsOnline)) {
            $this->context->addViolation($constraint->message, array('%locale%' => $nodeTranslation->getLang()));
        }
    }

    /**
     * Check if node parent is online.
     *
     * @param NodeInterface $node
     * @param string $locale
     *
     * @return bool
     */
    private function parentIsOnline(NodeInterface $node, $locale)
    {
        $parent = $node->getParent();

        if ((null !== $parent) && $this->routeHelper->hasController($parent->getType())) {
            if (false === $this->routeHelper->hasRoute($locale, $node)) {
                return false;
            }

            if (null === $translation = $parent->getTranslation($locale)) {
                return false;
            }

            if (null === $route = $translation->getRoute()) {
                return false;
            }

            return $route->isVisible();
        }

        return true;
    }
}
