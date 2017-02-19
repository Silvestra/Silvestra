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

use Tadcka\Component\Routing\Model\Manager\RouteManagerInterface;
use Silvestra\Bundle\NodeBundle\Routing\RouteProvider;
use \PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/1/14 4:41 PM
 */
class RouteProviderTest extends AbstractRoutingTest
{
    /**
     * @var MockObject|RouteManagerInterface
     */
    private $routeManager;

    /**
     * @var RouteProvider
     */
    private $routeProvider;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->routeManager = $this->getMock('Tadcka\\Component\\Routing\\Model\\Manager\\RouteManagerInterface');

        $this->routeProvider = new RouteProvider($this->routeManager);
    }

    /**
     * @expectedException \Silvestra\Bundle\NodeBundle\Exception\RouteException
     */
    public function testGetRouteNameWithoutId()
    {
        $node = $this->getMockNode();

        $this->routeProvider->getRouteName($node);
    }

    public function testGetRouteNameWithoutLocale()
    {
        $node = $this->getMockNode();

        $this->addNodeId(1, $node);

        $this->assertEquals('silvestra_node_node_translation_1', $this->routeProvider->getRouteName($node));
    }

    public function testGetRouteName()
    {
        $node = $this->getMockNode();

        $this->addNodeId(1, $node);

        $this->assertEquals('silvestra_node_node_translation_1_en', $this->routeProvider->getRouteName($node, 'en'));
    }
}
