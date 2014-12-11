<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\AdminBundle\EventListener;

use Silvestra\Component\Admin\Menu\AdminMenuItem;
use Silvestra\Component\Admin\Menu\Event\AdminMenuEventInterface;
use Silvestra\Component\Admin\Menu\Event\AdminMenuSubscriber;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.12.11 18.01
 */
class AdminMenuListener extends AdminMenuSubscriber
{

    /**
     * {@inheritdoc}
     */
    public function build(AdminMenuEventInterface $event)
    {
        $event->addItem(
            new AdminMenuItem(
                $this->translateTitle('menu.home', array(), 'SilvestraAdminBundle'),
                $this->generateRoute('silvestra_admin.homepage'),
                'dashboard',
                1000
            )
        );
    }
}
