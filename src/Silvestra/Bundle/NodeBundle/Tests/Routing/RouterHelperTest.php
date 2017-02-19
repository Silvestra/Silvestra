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

use Tadcka\Component\Tree\Model\NodeInterface;
use Silvestra\Bundle\NodeBundle\Routing\RouteGenerator;
use Silvestra\Bundle\NodeBundle\Routing\RouterHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/1/14 4:41 PM
 */
class RouterHelperTest extends AbstractRoutingTest
{
    /**
     * @var RouterHelper
     */
    private $routerHelper;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->routerHelper = new RouterHelper(
            array('test' => 'test_controller'),
            false,
            array(),
            RouteGenerator::STRATEGY_FULL_PATH
        );
    }

    /**
     * @expectedException \Silvestra\Bundle\NodeBundle\Exception\RouteException
     */
    public function testGetRouteControllerWithFakeNodeType()
    {
        $this->routerHelper->getRouteController('fake');
    }

    public function testGetRouteController()
    {
        $this->assertEquals('test_controller', $this->routerHelper->getRouteController('test'));
    }

    /**
     * @expectedException \Silvestra\Bundle\NodeBundle\Exception\RouteException
     */
    public function testGetRoutePatternWithoutNodeType()
    {
        $this->routerHelper->getRoutePattern('', $this->getMockNode(), 'en');
    }

    /**
     * @expectedException \Silvestra\Bundle\NodeBundle\Exception\RouteException
     */
    public function testGetRoutePatternWithEmptyPattern()
    {
        $node = $this->getMockNode();

        $this->addNodeType('test', $node);
        $this->routerHelper->getRoutePattern('', $node, 'en');
    }

    public function testGetRoutePatternWithoutParent()
    {
        $node = $this->getMockNode();

        $this->addNodeType('test', $node);

        $this->assertEquals('/test', $this->routerHelper->getRoutePattern('test', $node, 'en'));
    }

    public function testGetRoutePatternWithParent()
    {
        $node = $this->getMockNode();
        $parent = $this->getMockNode();

        $this->addNodeType('test', $node);
        $this->addNodeParent($parent, $node);

        $this->assertEquals('/test', $this->routerHelper->getRoutePattern('test', $node, 'en'));

        $this->fillParent($parent, null);

        $this->assertEquals('/test', $this->routerHelper->getRoutePattern('test', $node, 'en'));

        $parentTranslation = $parent->getTranslation('en');
        $this->addNodeTranslationTitle('Parent test', $parentTranslation);

        $this->assertEquals('/parent-test/test', $this->routerHelper->getRoutePattern('test', $node, 'en'));

        $parentParent = $this->getMockNode();

        $this->addNodeParent($parentParent, $parent);
        $this->fillParent($parentParent, 'Parent parent test');

        $this->assertEquals(
            '/parent-parent-test/parent-test/test',
            $this->routerHelper->getRoutePattern('test', $node, 'en')
        );
    }

    public function testHasController()
    {
        $this->assertFalse($this->routerHelper->hasController('fake'));
        $this->assertTrue($this->routerHelper->hasController('test'));
    }

    public function testNormalizeRoutePattern()
    {
        $this->assertEquals('', $this->routerHelper->normalizeRoutePattern(''));
        $this->assertEquals('/bump-bump', $this->routerHelper->normalizeRoutePattern('bump bump'));
        $this->assertEquals('/bump/bump', $this->routerHelper->normalizeRoutePattern('bump/bump/'));
        $this->assertEquals('/bump/bump', $this->routerHelper->normalizeRoutePattern(' /bump / bump'));
        $this->assertEquals('/bump/bump-test', $this->routerHelper->normalizeRoutePattern('/bump/bump test'));
        $this->assertEquals('/bump-test/bump', $this->routerHelper->normalizeRoutePattern('/bump test/bump'));
    }

    private function fillParent(NodeInterface $parent, $title)
    {
        $nodeTranslation = $this->getMockNodeTranslation();
        $route = $this->getMockRoute();

        $this->addNodeType('test', $parent);
        $this->addNodeTranslationRoute($route, $nodeTranslation);
        $this->addNodeTranslation($nodeTranslation, $parent);

        if ($title) {
            $this->addNodeTranslationTitle($title, $nodeTranslation);
        }
    }
}
