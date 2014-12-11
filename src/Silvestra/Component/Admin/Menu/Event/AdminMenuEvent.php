<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Admin\Menu\Event;

use Silvestra\Component\Admin\Menu\AdminMenuItem;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/11/14 1:46 AM
 */
class AdminMenuEvent extends Event implements AdminMenuEventInterface
{
    /**
     * @var array|AdminMenuItem[]
     */
    private $items = array();

    /**
     * {@inheritdoc}
     */
    public function addItem(AdminMenuItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * Get admin menu items.
     *
     * @return array|AdminMenuItem[]
     */
    public function getItems()
    {
        uasort(
            $this->items,
            function (AdminMenuItem $first, AdminMenuItem $second) {
                if ($first->getPriority() <= $second->getPriority()) {
                    return 1;
                }

                return -1;
            }
        );

        return $this->items;
    }
}
