<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\Text\NodeBundle\EventListener;

use Silvestra\Bundle\Text\NodeBundle\Handler\NodeHandler;
use Silvestra\Bundle\Text\NodeBundle\Model\TextNodeInterface;
use Tadcka\Bundle\SitemapBundle\Event\SitemapNodeEvent;
use Tadcka\Bundle\SitemapBundle\Frontend\Model\Tab;
use Tadcka\Component\Tree\Event\TreeNodeEvent;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class SitemapNodeListener
{

    /**
     * @var NodeHandler
     */
    private $nodeHandler;

    /**
     * @var array
     */
    private $textNodeTypes;

    /**
     * Constructor.
     *
     * @param NodeHandler $nodeHandler
     */
    public function __construct(NodeHandler $nodeHandler, array $textNodeTypes)
    {
        $this->nodeHandler = $nodeHandler;
        $this->textNodeTypes = $textNodeTypes;
    }

    /**
     * On edit node.
     *
     * @param SitemapNodeEvent $event
     */
    public function onSitemapNodeEdit(SitemapNodeEvent $event)
    {
        $node = $event->getNode();

        if (in_array($node->getType(), $this->textNodeTypes)) {
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
        if (TextNodeInterface::NODE_TYPE === $node->getType()) {
            $this->nodeHandler->onDeleteNode($node);
        }
    }
}
