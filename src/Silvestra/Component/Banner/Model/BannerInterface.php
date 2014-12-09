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

use Silvestra\Component\Media\Model\ImageInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface BannerInterface
{

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return BannerInterface
     */
    public function setTitle($title);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return BannerInterface
     */
    public function setDescription($description);

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set script.
     *
     * @param string $script
     *
     * @return BannerInterface
     */
    public function setScript($script);

    /**
     * Get script.
     *
     * @return string
     */
    public function getScript();

    /**
     * Set uri.
     *
     * @param string $uri
     *
     * @return BannerInterface
     */
    public function setUri($uri);

    /**
     * Get uri.
     *
     * @return string
     */
    public function getUri();

    /**
     * Set lang.
     *
     * @param string $lang
     *
     * @return BannerZoneInterface
     */
    public function setLang($lang);

    /**
     * Get lang.
     *
     * @return string
     */
    public function getLang();

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return BannerInterface
     */
    public function setPosition($position);

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition();

    /**
     * Set blank.
     *
     * @param bool $blank
     *
     * @return BannerInterface
     */
    public function setBlank($blank);

    /**
     * Check if is blank.
     *
     * @return bool
     */
    public function isBlank();

    /**
     * Set publish.
     *
     * @param bool $publish
     *
     * @return BannerInterface
     */
    public function setPublish($publish);

    /**
     * Check if is publish.
     *
     * @return bool
     */
    public function isPublish();

    /**
     * Set publish from.
     *
     * @param null|\Datetime $publishFrom
     *
     * @return BannerInterface
     */
    public function setPublishFrom(\Datetime $publishFrom = null);

    /**
     * Get publish from.
     *
     * @return null|\Datetime
     */
    public function getPublishFrom();

    /**
     * Set publish to.
     *
     * @param null|\Datetime $publishTo
     *
     * @return BannerInterface
     */
    public function setPublishTo(\Datetime $publishTo = null);

    /**
     * Get publish to.
     *
     * @return null|\Datetime
     */
    public function getPublishTo();

    /**
     * Set image.
     *
     * @param ImageInterface $image
     *
     * @return BannerInterface
     */
    public function setImage(ImageInterface $image);

    /**
     * Get image.
     *
     * @return ImageInterface
     */
    public function getImage();

    /**
     * Set zone.
     *
     * @param BannerZoneInterface $zone
     *
     * @return ImageInterface
     */
    public function setZone(BannerZoneInterface $zone);

    /**
     * Get zone.
     *
     * @return BannerZoneInterface
     */
    public function getZone();

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
