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
use Tadcka\Component\Tree\Model\Manager\NodeTranslationManagerInterface;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Event\TreeNodeEvent;
use Tadcka\Component\Tree\TadckaTreeEvents;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/1/14 8:01 PM
 */
class NodeRedirectRouteFormHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var NodeTranslationManagerInterface
     */
    private $nodeTranslationManager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param NodeTranslationManagerInterface $nodeTranslationManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        NodeTranslationManagerInterface $nodeTranslationManager,
        TranslatorInterface $translator
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->nodeTranslationManager = $nodeTranslationManager;
        $this->translator = $translator;
    }

    /**
     * Process node redirect route form.
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
                /** @var NodeInterface $node */
                $node = $form->getData();

                foreach ($node->getTranslations() as $nodeTranslation) {
                    $nodeTranslation->setNode($node);
                    $this->nodeTranslationManager->add($nodeTranslation);
                }

                return true;
            }
        }

        return false;
    }

    /**
     * On success.
     *
     * @param string $locale
     * @param NodeInterface $node
     *
     * @return string
     */
    public function onSuccess($locale, NodeInterface $node)
    {
        $this->eventDispatcher->dispatch(TadckaTreeEvents::NODE_EDIT_SUCCESS, new TreeNodeEvent($locale, $node));
        $this->nodeTranslationManager->save();

        return $this->translator->trans('success.node_redirect_route_save', array(), 'TadckaSitemapBundle');
    }
}
