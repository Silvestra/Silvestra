<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Routing;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/22/15 8:21 PM
 */
class RedirectRoute
{

    /**
     * Redirect route node controller.
     */
    const CONTROLLER = 'tadcka_routing.redirect_controller:redirectAction';

    /**
     * Redirect route node type.
     */
    const NODE_TYPE = 'redirect';
}
