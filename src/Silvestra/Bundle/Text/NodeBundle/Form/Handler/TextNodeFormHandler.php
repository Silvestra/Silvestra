<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\Text\NodeBundle\Form\Handler;

use Silvestra\Bundle\Text\NodeBundle\Model\Manager\TextNodeManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use Tadcka\Component\Tree\Event\TreeNodeEvent;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\TadckaTreeEvents;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/26/14 9:36 PM
 */
class TextNodeFormHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var TextNodeManagerInterface
     */
    private $textNodeManager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param TextNodeManagerInterface $textNodeManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        TextNodeManagerInterface $textNodeManager,
        TranslatorInterface $translator
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->textNodeManager = $textNodeManager;
        $this->translator = $translator;
    }

    /**
     * Process text node form.
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
                return true;
            }
        }

        return false;
    }

    /**
     * On edit text node success.
     *
     * @param string $locale
     * @param NodeInterface $node
     *
     * @return string
     */
    public function onSuccess($locale, NodeInterface $node)
    {
        $this->eventDispatcher->dispatch(TadckaTreeEvents::NODE_EDIT_SUCCESS, new TreeNodeEvent($locale, $node));
        $this->textNodeManager->save();

        return $this->translator->trans('success.text_node_save', array(), 'SilvestraTextNodeBundle');
    }
}
