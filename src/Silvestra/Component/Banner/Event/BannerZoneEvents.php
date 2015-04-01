<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Event;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/1/15 8:08 PM
 */
final class BannerZoneEvents
{

    /**
     * Create banner zone event.
     */
    const CREATE = 'silvestra_banner_zone.create';

    /**
     * Edit banner zone event.
     */
    const EDIT = 'silvestra_banner_zone.edit';

    /**
     * Delete banner zone event.
     */
    const DELETE = 'silvestra_banner_zone.delete';

    private function __construct()
    {
    }
}
