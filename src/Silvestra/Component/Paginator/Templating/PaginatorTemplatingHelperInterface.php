<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Paginator\Request;

use Silvestra\Component\Paginator\Pagination;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 15.3.4 15.57
 */
interface PaginatorTemplatingHelperInterface
{
    /**
     * Get pagination relative url.
     *
     * @param Request $request
     * @param null|string $routeName
     * @param array $parameters
     *
     * @return string
     */
    public function getPath(Request $request, $routeName = null, array $parameters = array());

    /**
     * Render pagination
     *
     * @param Pagination $pagination
     * @param array $parameters
     * @param null|string $template
     *
     * @return string
     */
    public function render(Pagination $pagination, array $parameters = array(), $template = null);
}
