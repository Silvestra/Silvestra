<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Tests\Registry;

use Silvestra\Component\Banner\Registry\BannerZoneConfig;
use Silvestra\Component\Banner\Registry\BannerZoneRegistry;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/5/14 10:59 PM
 */
class BannerZoneRegistryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BannerZoneRegistry
     */
    private $registry;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->registry = new BannerZoneRegistry();
    }

    public function testHasConfig()
    {
        $this->assertFalse($this->registry->hasConfig('silvestra'));

        $this->registry->addConfig($this->createConfig('silvestra'));

        $this->assertTrue($this->registry->hasConfig('silvestra'));
    }

    public function testGetConfig()
    {
        $this->assertEmpty($this->registry->getConfig('silvestra'));

        $config = $this->createConfig('silvestra');
        $this->registry->addConfig($config);

        $this->assertEquals($config, $this->registry->getConfig('silvestra'));
    }

    public function testGetConfigs()
    {
        $this->assertEmpty($this->registry->getConfigs());

        $config = $this->createConfig('silvestra');
        $this->registry->addConfig($config);

        $configs = $this->registry->getConfigs();

        $this->assertCount(1, $configs);
        $this->assertEquals($config, $configs['silvestra']);

        $this->registry->addConfig($config);

        $configs = $this->registry->getConfigs();

        $this->assertCount(1, $configs);
        $this->assertEquals($config, $configs['silvestra']);
    }

    private function createConfig($slug)
    {
        return new BannerZoneConfig('Silvestra', $slug);
    }
}
