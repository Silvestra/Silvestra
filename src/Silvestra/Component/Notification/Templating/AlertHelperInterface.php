<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Notification\Templating;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/8/14 12:40 PM
 */
interface AlertHelperInterface
{
    /**
     * Render alert template.
     *
     * @param array $context
     * @param string $template
     *
     * @return string
     */
    public function render(array $context, $template = null);
}
