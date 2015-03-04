<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Paginator\Url;

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
     * @param Request $request
     * @param null|string $routeName
     * @param array $parameters
     *
     * @return string
     */
    public function getRelativeUrl(Request $request, $routeName = null, array $parameters = array())
    {
        $parameters = array_merge($this->getUrlParameters($request), $parameters);

        if (null === $routeName) {
            $routeName = $request->attributes->get('_route');
        }

        return $this->router->generate($routeName, $parameters);
    }

    /**
     * Get url parameters.
     *
     * @param Request $request
     *
     * @return array
     */
    private function getUrlParameters(Request $request)
    {
        $parameters = $request->query->all();
        if ($routeParameters = $request->attributes->get('_route_params')) {
            $parameters = array_merge($routeParameters, $parameters);
        }

        return $parameters;
    }
}
