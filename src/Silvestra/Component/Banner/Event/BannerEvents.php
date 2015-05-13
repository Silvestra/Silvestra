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
 * @since 4/1/15 8:04 PM
 */
final class BannerEvents
{

    /**
     * Create banner event.
     */
    const CREATE = 'silvestra_banner.create';

    /**
     * Edit banner event.
     */
    const EDIT = 'silvestra_banner.edit';

    /**
     * Delete banner event.
     */
    const DELETE = 'silvestra_banner.delete';

    private function __construct()
    {
    }
}
