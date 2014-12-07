<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Registry;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/3/14 1:39 AM
 */
class BannerZoneRegistry
{
    /**
     * @var array|BannerZoneConfig[]
     */
    private $configs;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->configs = array();
    }

    /**
     * Add config.
     *
     * @param BannerZoneConfig $config
     */
    public function addConfig(BannerZoneConfig $config)
    {
        $this->configs[$config->getSlug()] = $config;
    }

    /**
     * Get config.
     *
     * @param string $slug
     *
     * @return null|BannerZoneConfig
     */
    public function getConfig($slug)
    {
        if ($this->hasConfig($slug)) {
            return $this->configs[$slug];
        }

        return null;
    }

    /**
     * Get banner zone configs.
     *
     * @return array|BannerZoneConfig[]
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * Check if has banner zone config by slug.
     *
     * @param string $slug
     *
     * @return bool
     */
    public function hasConfig($slug)
    {
        return isset($this->configs[$slug]);
    }
}
