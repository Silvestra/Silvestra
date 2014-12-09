<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Model;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface BannerZoneInterface
{

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return BannerZoneInterface
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();


    /**
     * Set code.
     *
     * @param string $code
     *
     * @return BannerZoneInterface
     */
    public function setCode($code);

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode();

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return BannerZoneInterface
     */
    public function setSlug($slug);

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Set width.
     *
     * @param int $width
     *
     * @return BannerZoneInterface
     */
    public function setWidth($width);

    /**
     * Get width.
     *
     * @return int
     */
    public function getWidth();

    /**
     * Set height.
     *
     * @param int $height
     *
     * @return BannerZoneInterface
     */
    public function setHeight($height);

    /**
     * Get height.
     *
     * @return int
     */
    public function getHeight();

    /**
     * Set banners.
     *
     * @param array|BannerInterface[] $banners
     *
     * @return BannerZoneInterface
     */
    public function setBanners($banners);

    /**
     * Get banners.
     *
     * @return array|BannerInterface[]
     */
    public function getBanners();

    /**
     * Add banner.
     *
     * @param BannerInterface $banner
     */
    public function addBanner(BannerInterface $banner);

    /**
     * Remove banner.
     *
     * @param BannerInterface $banner
     */
    public function removeBanner(BannerInterface $banner);

    /**
     * Set createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return BannerInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();
}
