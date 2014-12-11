<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Admin\Templating;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.12.11 17.12
 */
interface AdminMenuHelperInterface
{
    /**
     * Render admin menu.
     *
     * @param string $name
     * @param array $menu
     *
     * @return string
     */
    public function render($name, array $menu);
}
