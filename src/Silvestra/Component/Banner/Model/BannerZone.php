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
class BannerZone implements BannerZoneInterface
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var bool
     */
    protected $system;

    /**
     * @var array|BannerInterface[]
     */
    protected $banners;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
        $this->system = false;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * {@inheritdoc}
     */
    public function setSystem($system)
    {
        $this->system = $system;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isSystem()
    {
        return $this->system;
    }

    /**
     * {@inheritdoc}
     */
    public function setBanners($banners)
    {
        $this->banners = $banners;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * {@inheritdoc}
     */
    public function addBanner(BannerInterface $banner)
    {
        $this->banners[] = $banner;
    }

    /**
     * {@inheritdoc}
     */
    public function removeBanner(BannerInterface $banner)
    {
        // TODO: Implement removeBanners() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
