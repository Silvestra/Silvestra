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

use Silvestra\Component\Seo\Model\Manager\SeoMetadataManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Event\TreeNodeEvent;
use Tadcka\Component\Tree\TadckaTreeEvents;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.6.29 14.47
 */
class NodeSeoFormHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var SeoMetadataManagerInterface
     */
    private $seoMetadataManager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param SeoMetadataManagerInterface $seoMetadataManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        SeoMetadataManagerInterface $seoMetadataManager,
        TranslatorInterface $translator
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->seoMetadataManager = $seoMetadataManager;
        $this->translator = $translator;
    }

    /**
     * Process node seo form.
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

                foreach ($node->getTranslations() as $translation) {
                    if (null !== $seoMetadata = $translation->getSeoMetadata()) {
                        $this->seoMetadataManager->add($seoMetadata);
                    }
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
        $this->seoMetadataManager->save();

        return $this->translator->trans('success.node_seo_save', array(), 'TadckaSitemapBundle');
    }
}
