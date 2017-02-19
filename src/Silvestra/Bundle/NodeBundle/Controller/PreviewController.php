<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Tadcka\Component\Routing\Model\Manager\RouteManagerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 8/4/14 11:10 PM
 */
class PreviewController
{
    /**
     * @var HttpKernelInterface
     */
    private $httpKernel;

    /**
     * @var RouteManagerInterface
     */
    private $routeManager;

    /**
     * Constructor.
     *
     * @param HttpKernelInterface $httpKernel
     * @param RouteManagerInterface $routeManager
     */
    public function __construct(HttpKernelInterface $httpKernel, RouteManagerInterface $routeManager)
    {
        $this->httpKernel = $httpKernel;
        $this->routeManager = $routeManager;
    }

    /**
     * Sitemap preview index action.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     */
    public function indexAction(Request $request)
    {
        $route = null;

        if (null !== $routePattern = $request->get('route', null)) {
            $route = $this->routeManager->findByRoutePattern($routePattern);
        }

        if (null === $route) {
            throw new NotFoundHttpException(sprintf('Not found route: %s', $routePattern));
        }

        $query = array('_route_params' => array('_route_object' => $route));
        $subRequest = $request->duplicate($query, null, $route->getDefaults());

        return $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
    }
}
