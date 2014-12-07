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

use Silvestra\Component\Banner\Model\BannerInterface;
use Silvestra\Component\Banner\Model\BannerZoneInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface BannerManagerInterface
{
    /**
     * Find banner by id.
     *
     * @param int $id
     *
     * @return null|BannerInterface
     */
    public function findById($id);

    /**
     * Find many banners by banner zone.
     *
     * @param BannerZoneInterface $bannerZone
     *
     * @return array|BannerInterface[]
     */
    public function findManyByZone(BannerZoneInterface $bannerZone);

    /**
     * Create new Banner object.
     *
     * @return BannerInterface
     */
    public function create();

    /**
     * Add Banner object to persistent layer.
     *
     * @param BannerInterface $banner
     * @param bool $save
     */
    public function add(BannerInterface $banner, $save = false);

    /**
     * Remove Banner object from persistent layer.
     *
     * @param BannerInterface $banner
     * @param bool $save
     */
    public function remove(BannerInterface $banner, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear Banner objects from persistent layer.
     */
    public function clear();

    /**
     * Get Banner object class name.
     *
     * @return string
     */
    public function getClass();
}
