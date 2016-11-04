<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Paginator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 15.3.4 15.57
 */
class UrlHelper
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Get relative url.
     *
     * @param string $page
     * @param Request $request
     *
     * @return string
     */
    public function getRelativeUrl($page, Request $request)
    {
        return $this->router->generate(
            $request->attributes->get('_route'),
            array_merge($this->getParametersFromRequest($request), array('page' => $page))
        );
    }

    /**
     * Get parameters from request.
     *
     * @param Request $request
     *
     * @return array
     */
    private function getParametersFromRequest(Request $request)
    {
        $parameters = $request->query->all();
        if ($routeParameters = $request->attributes->get('_route_params')) {
            $parameters = array_merge($routeParameters, $parameters);
        }

        return $parameters;
    }
}
