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
 * @since 12/3/14 1:50 AM
 */
class BannerZoneConfig
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var null|string
     */
    private $translationDomain;

    /**
     * @var array
     */
    private $size;

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $slug
     * @param array $size
     */
    public function __construct($name, $slug, array $size)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->size = $size;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get banner size.
     *
     * @return array
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set translation domain.
     *
     * @param string $translationDomain
     */
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
    }

    /**
     * Get translation domain.
     *
     * @return null|string
     */
    public function getTranslationDomain()
    {
        return $this->translationDomain;
    }
}
