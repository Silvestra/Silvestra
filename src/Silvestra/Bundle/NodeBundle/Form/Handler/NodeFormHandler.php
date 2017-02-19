<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Form\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Event\TreeNodeEvent;
use Tadcka\Component\Tree\Model\Manager\NodeManagerInterface;
use Tadcka\Component\Tree\TadckaTreeEvents;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  5/19/14 11:41 PM
 */
class NodeFormHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var NodeManagerInterface
     */
    private $nodeManager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param NodeManagerInterface $nodeManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        NodeManagerInterface $nodeManager,
        TranslatorInterface $translator
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->nodeManager = $nodeManager;
        $this->translator = $translator;
    }

    /**
     * Process node form.
     *
     * @param Request $request
     * @param FormInterface $form
     *
     * @return bool
     */
    public function process(Request $request, FormInterface $form)
    {
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->nodeManager->add($form->getData());

                return true;
            }
        }

        return false;
    }

    /**
     * On node create success.
     *
     * @param string $locale
     * @param NodeInterface $node
     *
     * @return string
     */
    public function onCreateSuccess($locale, NodeInterface $node)
    {
        $event = $this->createTreeNodeEvent($locale, $node);

        $this->eventDispatcher->dispatch(TadckaTreeEvents::NODE_PRE_CREATE, $event);
        $this->nodeManager->save();
        $this->eventDispatcher->dispatch(TadckaTreeEvents::NODE_CREATE_SUCCESS, $event);
        $this->nodeManager->save();

        return $this->translator->trans('success.create_node', array(), 'TadckaSitemapBundle');
    }

    /**
     * On node edit success.
     *
     * @param string $locale
     * @param NodeInterface $node
     *
     * @return string
     */
    public function onEditSuccess($locale, NodeInterface $node)
    {
        $event = $this->createTreeNodeEvent($locale, $node);

        $this->eventDispatcher->dispatch(TadckaTreeEvents::NODE_EDIT_SUCCESS, $event);
        $this->nodeManager->save();

        return $this->translator->trans('success.edit_node', array(), 'TadckaSitemapBundle');
    }

    /**
     * Create tree node event.
     *
     * @param string $locale
     * @param NodeInterface $node
     *
     * @return TreeNodeEvent
     */
    private function createTreeNodeEvent($locale, NodeInterface $node)
    {
        return new TreeNodeEvent($locale, $node);
    }
}
