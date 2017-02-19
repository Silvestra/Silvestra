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

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Tadcka\Component\Tree\Provider\NodeProviderInterface;
use Tadcka\Component\Tree\Registry\NodeType\NodeTypeConfig;
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 5/19/14 10:56 PM
 */
class NodeFormFactory
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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var NodeProviderInterface
     */
    private $nodeProvider;

    /**
     * @var string
     */
    private $nodeClass;

    /**
     * @var string
     */
    private $translationClass;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     * @param NodeProviderInterface $nodeProvider
     * @param string $nodeClass
     * @param string $translationClass
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        TranslatorInterface $translator,
        NodeProviderInterface $nodeProvider,
        $nodeClass,
        $translationClass
    ) {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->translator = $translator;
        $this->nodeProvider = $nodeProvider;
        $this->nodeClass = $nodeClass;
        $this->translationClass = $translationClass;
    }


    /**
     * Create node form.
     *
     * @param NodeInterface $node
     *
     * @return FormInterface
     */
    public function create(NodeInterface $node)
    {
        return $this->formFactory->create(
            'tadcka_node',
            $node,
            array(
                'action' => $this->router->getContext()->getPathInfo(),
                'data_class' => $this->nodeClass,
                'translation_class' => $this->translationClass,
                'node_types' => $this->getNodeTypes($node),
                'is_root' => (null === $node->getParent())
            )
        );
    }

    /**
     * Get node types.
     *
     * @param NodeInterface $node
     *
     * @return array
     */
    protected function getNodeTypes(NodeInterface $node)
    {
        $nodeTypes = array();
        if (null !== $node->getParent()) {
            foreach ($this->nodeProvider->getActiveNodeTypes($node) as $nodeType) {
                $nodeTypes[$nodeType] = $this->getNodeTypeName($this->nodeProvider->getNodeTypeConfig($nodeType));
            }
        }

        return $nodeTypes;
    }

    /**
     * Get node type name.
     *
     * @param NodeTypeConfig $config
     *
     * @return string
     */
    private function getNodeTypeName(NodeTypeConfig $config)
    {
        $name = $config->getName();
        if ($config->getTranslationDomain()) {
            $name = $this->translator->trans($config->getName(), array(), $config->getTranslationDomain());
        }

        return $name;
    }
}
