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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/11/14 1:48 AM
 */
interface AdminMenuEventInterface
{
    /**
     * Add admin menu item.
     *
     * @param AdminMenuItem $item
     */
    public function addItem(AdminMenuItem $item);
}
