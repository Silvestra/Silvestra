<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use Tadcka\Component\Tree\Model\Manager\NodeManagerInterface;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Event\TreeNodeEvent;
use Tadcka\Component\Tree\TadckaTreeEvents;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  14.10.24 17.33
 */
class NodeDeleteHandler
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
     * Process node delete.
     *
     * @param NodeInterface $node
     * @param Request $request
     *
     * @return bool
     */
    public function process(NodeInterface $node, Request $request)
    {
        if ((null !== $node->getParent()) && $request->isMethod('DELETE')) {
            $event = $this->createTreeNodeEvent($request->getLocale(), $node);

            $this->eventDispatcher->dispatch(TadckaTreeEvents::NODE_PRE_DELETE, $event);
            $this->nodeManager->remove($node, true);

            return true;
        }

        return false;
    }

    /**
     * On success node delete.
     *
     * @param string $locale
     * @param NodeInterface $node
     *
     * @return string
     */
    public function onSuccess($locale, NodeInterface $node)
    {
        $event = $this->createTreeNodeEvent($locale, $node);

        $this->eventDispatcher->dispatch(TadckaTreeEvents::NODE_DELETE_SUCCESS, $event);
        $this->nodeManager->save();

        return $this->translator->trans(
            'success.delete_node',
            array('%title%' => $this->getNodeTitle($locale, $node)),
            'TadckaSitemapBundle'
        );
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

    /**
     * Get node title.
     *
     * @param string $locale
     * @param NodeInterface $node
     *
     * @return string
     */
    private function getNodeTitle($locale, NodeInterface $node)
    {
        if (null !== $translation = $node->getTranslation($locale)) {
            return $translation->getTitle();
        }

        return $this->translator->trans('not_found_title', array(), 'TadckaSitemapBundle');
    }
}
