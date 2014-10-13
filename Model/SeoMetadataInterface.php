<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo\Model;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface SeoMetadataInterface
{
    /**
     * Set language.
     *
     * @param string $lang
     *
     * @return SeoMetadataInterface
     */
    public function setLang($lang);

    /**
     * Get language.
     *
     * @return string
     */
    public function getLang();

    /**
     * Set metaDescription.
     *
     * @param string $metaDescription
     *
     * @return SeoMetadataInterface
     */
    public function setMetaDescription($metaDescription);

    /**
     * Get metaDescription.
     *
     * @return string
     */
    public function getMetaDescription();

    /**
     * Set metaKeywords.
     *
     * @param string $metaKeywords
     *
     * @return SeoMetadataInterface
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * Get metaKeywords.
     *
     * @return string
     */
    public function getMetaKeywords();

    /**
     * Set metaRobots.
     *
     * @param string $metaRobots
     *
     * @return SeoMetadataInterface
     */
    public function setMetaRobots($metaRobots);

    /**
     * Get metaRobots.
     *
     * @return string
     */
    public function getMetaRobots();

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return SeoMetadataInterface
     */
    public function setTitle($title);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();
}
