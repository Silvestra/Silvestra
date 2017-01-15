<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\Text\NodeBundle\Form\Factory;

use Silvestra\Bundle\Text\NodeBundle\Model\TextNodeInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class TextNodeFormFactory
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
     * Create text form.
     *
     * @param TextNodeInterface $textNode
     *
     * @return FormInterface
     */
    public function create(TextNodeInterface $textNode)
    {
        return $this->formFactory->create(
            'silvestra_text_node',
            $textNode,
            array(
                'method' => 'POST',
                'action' => $this->router->getContext()->getPathInfo(),
            )
        );
    }
}
