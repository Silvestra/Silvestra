<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Model\Manager;

use Silvestra\Component\Banner\Model\BannerZoneInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface BannerZoneManagerInterface
{
    /**
     * Find banner zone by id.
     *
     * @param int $id
     *
     * @return null|BannerZoneInterface
     */
    public function findById($id);

    /**
     * Find all banner zones.
     *
     * @return array|BannerZoneInterface[]
     */
    public function findAll();

    /**
     * Find banner zone by slug.
     *
     * @param string $slug
     *
     * @return null|BannerZoneInterface
     */
    public function findBySlug($slug);

    /**
     * Find banner zone existing slugs.
     *
     * @return array
     */
    public function findExistingSlugs();

    /**
     * Find system banner zone slugs.
     *
     * @return array
     */
    public function findSystemSlugs();

    /**
     * Create new BannerZone object.
     *
     * @return BannerZoneInterface
     */
    public function create();

    /**
     * Add BannerZone object to persistent layer.
     *
     * @param BannerZoneInterface $bannerZone
     * @param bool $save
     */
    public function add(BannerZoneInterface $bannerZone, $save = false);

    /**
     * Remove BannerZone object from persistent layer.
     *
     * @param BannerZoneInterface $bannerZone
     * @param bool $save
     */
    public function remove(BannerZoneInterface $bannerZone, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear BannerZone objects from persistent layer.
     */
    public function clear();

    /**
     * Get BannerZone object class name.
     *
     * @return string
     */
    public function getClass();
}
