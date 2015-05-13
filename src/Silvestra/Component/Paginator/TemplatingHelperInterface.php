<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Paginator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 15.3.4 15.57
 */
interface TemplatingHelperInterface
{

    /**
     * Render pagination.
     *
     * @param Pagination $pagination
     * @param array $parameters
     * @param null|string $template
     *
     * @return string
     */
    public function render(Pagination $pagination, array $parameters = array(), $template = null);
}
