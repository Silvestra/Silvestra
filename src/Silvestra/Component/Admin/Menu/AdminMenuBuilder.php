<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Admin\Menu;

use Silvestra\Component\Admin\Admin;
use Silvestra\Component\Admin\Menu\Event\AdminMenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/11/14 1:44 AM
 */
class AdminMenuBuilder
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Build admin menu.
     *
     * @return array|AdminMenuItem[]
     */
    public function build()
    {
        $event = new AdminMenuEvent();

        $this->eventDispatcher->dispatch(Admin::MENU, $event);

        return $event->getItems();
    }
}
