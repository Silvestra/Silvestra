<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Form\Factory;

use Silvestra\Bundle\NodeBundle\Form\Type\NodeRedirectRouteType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/1/14 7:58 PM
 */
class NodeRedirectRouteFormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * Create node redirect route form.
     *
     * @param NodeInterface $node
     *
     * @return FormInterface
     */
    public function create(NodeInterface $node)
    {
        return $this->formFactory->create(
            NodeRedirectRouteType::class,
            $node,
            array(
                'action' => $this->router->getContext()->getPathInfo()
            )
        );
    }
}
