<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SiteBundle\EventListener;

use Silvestra\Component\Admin\Menu\AdminMenuItem;
use Silvestra\Component\Admin\Menu\Event\AdminMenuEventInterface;
use Silvestra\Component\Admin\Menu\Event\AdminMenuSubscriber;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/28/14 10:46 PM
 */
class AdminMenuListener extends AdminMenuSubscriber
{
    /**
     * {@inheritdoc}
     */
    public function build(AdminMenuEventInterface $event)
    {
        $siteMenu = new AdminMenuItem(
            $this->translateTitle('site', array(), 'SilvestraSite'),
            'javascript:;',
            'globe',
            900
        );

        $siteMenu->addChild(
            new AdminMenuItem(
                $this->translateTitle('menu.general_information', array(), 'SilvestraSite'),
                $this->generateRoute('silvestra_site'),
                'info-circle'
            )
        );

        $siteMenu->addChild(
            new AdminMenuItem(
                $this->translateTitle('menu.sitemap', array(), 'SilvestraSite'),
                $this->generateRoute('tadcka_sitemap'),
                'sitemap'
            )
        );

        $event->addItem($siteMenu);
    }
}
