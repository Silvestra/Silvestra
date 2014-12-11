<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\BannerBundle\EventListener;

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
        $event->addItem(
            new AdminMenuItem(
                $this->translateTitle('title.banner_zone.list', array(), 'SilvestraBanner'),
                $this->generateRoute('silvestra_banner.banner_zone_list'),
                'image'
            )
        );
    }
}
