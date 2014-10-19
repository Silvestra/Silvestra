<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\TextNodeBundle\EventListener;

use Silvestra\Bundle\TextNodeBundle\Model\Manager\TextNodeManagerInterface;
use Silvestra\Component\Text\Model\Manager\TextManagerInterface;
use Tadcka\Bundle\SitemapBundle\Event\SitemapNodeEvent;
use Tadcka\Bundle\SitemapBundle\Frontend\Model\Tab;
use Tadcka\Component\Tree\Event\TreeNodeEvent;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class SitemapNodeListener
{
    /**
     * @var TextManagerInterface
     */
    private $textManager;

    /**
     * @var TextNodeManagerInterface
     */
    private $textNodeManager;

    /**
     * Constructor.
     *
     * @param TextManagerInterface $textManager
     * @param TextNodeManagerInterface $textNodeManager
     */
    public function __construct(TextManagerInterface $textManager, TextNodeManagerInterface $textNodeManager)
    {
        $this->textManager = $textManager;
        $this->textNodeManager = $textNodeManager;
    }

    /**
     * On edit node.
     *
     * @param SitemapNodeEvent $event
     */
    public function onSitemapNodeEdit(SitemapNodeEvent $event)
    {
        $node = $event->getNode();

        if ('text' === $node->getType()) {
            $tab = new Tab(
                $event->getTranslator()->trans('text', array(), 'SilvestraTextNodeBundle'),
                'silvestra_text_node',
                $event->getRouter()->generate(
                    'silvestra_text_node',
                    array('_format' => 'json', 'nodeId' => $node->getId())
                )
            );

            $event->addTab($tab);
        }
    }

    /**
     * On sitemap node delete.
     *
     * @param TreeNodeEvent $event
     */
    public function onSitemapNodeDelete(TreeNodeEvent $event)
    {
        $node = $event->getNode();
        if ('text' === $node->getType()) {
            $textNode = $this->textNodeManager->findTextNodeByNode($node);
            if (null !== $textNode) {
                $this->textNodeManager->remove($textNode);
                $this->textManager->delete($textNode->getText());
            }
        }
    }
}
