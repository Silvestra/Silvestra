<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Tests\Routing;

use Tadcka\Component\Routing\Model\RouteInterface;
use Silvestra\Bundle\NodeBundle\Routing\RouteGenerator;
use Silvestra\Bundle\NodeBundle\Routing\RouteProvider;
use Silvestra\Bundle\NodeBundle\Routing\RouterHelper;
use \PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/29/14 8:10 PM
 */
class RouteGeneratorTest extends AbstractRoutingTest
{
    /**
     * @var RouteGenerator
     */
    private $routeGenerator;

    /**
     * @var MockObject|RouteProvider
     */
    private $routeProvider;

    /**
     * @var RouterHelper
     */
    private $routerHelper;

    protected function setUp()
    {
        $this->routeProvider = $this->getMockBuilder('Tadcka\\Bundle\\SitemapBundle\\Routing\\RouteProvider')
            ->disableOriginalConstructor()
            ->getMock();

        $this->routerHelper = new RouterHelper(
            array('test' => 'test_controller'),
            true,
            array(),
            RouteGenerator::STRATEGY_FULL_PATH
        );
        $this->routeGenerator = new RouteGenerator($this->routeProvider, $this->routerHelper);
    }

    /**
     * @expectedException \Silvestra\Bundle\NodeBundle\Exception\RouteException
     */
    public function testGenerateRouteWithEmptyPattern()
    {
        $route = $this->getMockRoute();
        $node = $this->getMockNode();

        $this->addNodeType('test', $node);

        $this->routeGenerator->generateRoute($route, $node, 'en');
    }

    public function testGenerateRoute()
    {
        $route = $this->getMockRoute();
        $node = $this->getMockNode();

        $this->addRoutePattern('test', $route);

        $object = $this;
        $routePattern = function ($routePattern) use ($object) {
            $object->assertEquals('/test', $routePattern);
        };

        $this->addRouteMethodSetRoutePattern($routePattern, $route);
        $this->addNodeType('test', $node);

        $this->routeGenerator->generateRoute($route, $node, 'en');
    }

    public function testGenerateRouteDuplicate()
    {
        $route = $this->getMockRoute();
        $node = $this->getMockNode();

        $this->addRoutePattern('/test', $route);
        $this->addRouteName('test', $route);

        $object = $this;
        $callback = function ($routePattern) use ($object) {
            $object->assertEquals('/test', $routePattern);
        };

        $this->addRouteMethodSetRoutePattern($callback, $route);
        $this->addNodeType('test', $node);
        $this->addRouteProviderMethodGetRouteByPattern($route);

        $this->routeGenerator->generateRoute($route, $node, 'en');
    }

    public function testGenerateUniqueRoute()
    {
        $route = $this->getMockRoute();
        $node = $this->getMockNode();

        $this->addRoutePattern('/test', $route);

        $object = $this;
        $callback = function ($routePattern) use ($object) {
            $object->assertEquals('/test', $routePattern);
        };

        $this->addRouteMethodSetRoutePattern($callback, $route);
        $this->addNodeType('test', $node);

        $existingRoute = $this->getMockRoute();
        $this->addRoutePattern('/test-1', $existingRoute);
        $this->addRouteName('test', $existingRoute);
        $this->addRouteProviderMethodGetRouteByPattern($existingRoute);

        $this->routeGenerator->generateRoute($route, $node, 'en');
    }

    /**
     * @param \Closure $callback
     * @param MockObject|RouteInterface $route
     */
    private function addRouteMethodSetRoutePattern($callback, MockObject $route)
    {
        $route->expects($this->any())
            ->method('setRoutePattern')
            ->will($this->returnCallback($callback));
    }

    /**
     * @param MockObject|RouteInterface $route
     */
    private function addRouteProviderMethodGetRouteByPattern(MockObject $route)
    {
        $this->routeProvider->expects($this->any())
            ->method('getRouteByPattern')
            ->will(
                $this->returnCallback(
                    function ($routePattern) use ($route) {
                        if ($routePattern === $route->getRoutePattern()) {
                            return $route;
                        }

                        return null;
                    }
                )
            );
    }

    /**
     * @param string $name
     * @param MockObject|RouteInterface $route
     */
    private function addRouteName($name, MockObject $route)
    {
        $route->expects($this->any())
            ->method('getName')
            ->willReturn($name);
    }
}
