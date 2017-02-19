<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Tests\Provider;

use \PHPUnit_Framework_MockObject_MockObject as MockObject;
use Tadcka\Component\Tree\Model\Manager\NodeManagerInterface;
use Silvestra\Bundle\NodeBundle\Provider\SitemapProvider;
use Tadcka\Component\Tree\Provider\TreeProviderInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/3/14 10:59 AM
 */
class SitemapProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockObject|NodeManagerInterface
     */
    private $nodeManager;

    /**
     * @var MockObject|TreeProviderInterface
     */
    private $treeProvider;

    /**
     * @var SitemapProvider
     */
    private $sitemapProvider;

    protected function setUp()
    {
        $this->nodeManager = $this
            ->getMockBuilder('Tadcka\\Component\\Tree\\Model\\Manager\\NodeManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->nodeManager
            ->expects($this->any())
            ->method('create')
            ->willReturn($this->getMock('Tadcka\\Component\\Tree\\Model\\NodeInterface'));

        $this->treeProvider = $this->getMockBuilder('Tadcka\\Component\\Tree\\Provider\\TreeProviderInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->sitemapProvider = new SitemapProvider($this->nodeManager, $this->treeProvider);
    }

    /**
     * @expectedException \Silvestra\Bundle\NodeBundle\Exception\ResourceNotFoundException
     */
    public function testGetRootNodeWithoutTree()
    {
        $this->sitemapProvider->getRootNode();
    }

    public function testGetRootNode()
    {
        $this->addTree();

        $this->assertNotEmpty($this->sitemapProvider->getRootNode());
    }

    private function addTree()
    {
        $this->treeProvider
            ->expects($this->any())
            ->method('getTree')
            ->willReturn($this->getMock('Tadcka\\Component\\Tree\\Model\\TreeInterface'));
    }
}
