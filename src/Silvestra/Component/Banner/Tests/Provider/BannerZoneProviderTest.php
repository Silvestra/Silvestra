<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Tests\Provider;

use Silvestra\Component\Banner\Model\Manager\BannerZoneManagerInterface;
use Silvestra\Component\Banner\Provider\BannerZoneProvider;
use Silvestra\Component\Banner\Registry\BannerZoneConfig;
use Silvestra\Component\Banner\Registry\BannerZoneRegistry;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/5/14 10:50 PM
 */
class BannerZoneProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BannerZoneManagerInterface
     */
    private $manager;

    /**
     * @var BannerZoneProvider
     */
    private $provider;

    /**
     * @var BannerZoneRegistry
     */
    private $registry;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $mockTranslator = $this->getMock('Symfony\\Component\\Translation\\TranslatorInterface');
        $this->manager = $this->getMock('Silvestra\\Component\\Banner\\Model\\Manager\\BannerZoneManagerInterface');
        $this->manager->expects($this->any())
            ->method('findExistingSlugs')
            ->willReturn(array());

        $this->registry = new BannerZoneRegistry();
        $this->provider = new BannerZoneProvider($this->manager, $this->registry, $mockTranslator);
    }

    public function testEmptyGetConfigChoiceList()
    {
        $this->assertEmpty($this->provider->getConfigChoices(null));
    }

    public function testGetConfigChoiceList()
    {
        $this->registry->addConfig(new BannerZoneConfig('Silvestra homepage', 'silvertra_homepage'));
        $this->registry->addConfig(new BannerZoneConfig('Silvestra text', 'silvertra_text'));

        $list = $this->provider->getConfigChoices(null);

        $this->assertCount(2, $list);
        $this->assertEquals('Silvestra homepage', $list['silvertra_homepage']);
        $this->assertEquals('Silvestra text', $list['silvertra_text']);
    }
}
