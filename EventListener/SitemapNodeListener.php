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

use Tadcka\Bundle\SitemapBundle\Event\SitemapNodeEvent;
use Tadcka\Bundle\SitemapBundle\Frontend\Model\Tab;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class SitemapNodeListener
{
    /**
     * On edit node.
     *
     * @param SitemapNodeEvent $event
     */
    public function onSitemapNodeEdit(SitemapNodeEvent $event)
    {
        if ('text' === $event->getNode()->getType()) {
            $tab = new Tab(
                $event->getTranslator()->trans('text', array(), 'SilvestraTextNodeBundle'),
                'tadcka_text_node',
                $event->getRouter()->generate('silvestra_text_node', array('nodeId' => $event->getNode()->getId()))
            );

            $event->addTab($tab);
        }
    }
}
