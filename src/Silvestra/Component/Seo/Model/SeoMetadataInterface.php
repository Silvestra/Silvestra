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
     * Set original URL.
     *
     * @param string $originalUrl
     *
     * @return SeoMetadataInterface
     */
    public function setOriginalUrl($originalUrl);

    /**
     * Get original URL.
     *
     * @return string
     */
    public function getOriginalUrl();

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

    /**
     * Get extra http.
     *
     * @return array
     */
    public function getExtraHttp();

    /**
     * Set extra http.
     *
     * @param array $extraHttp
     *
     * @return SeoMetadataInterface
     */
    public function setExtraHttp(array $extraHttp);

    /**
     * Add a key-value pair for meta attribute http-equiv.
     *
     * @param string $key
     * @param string $value
     */
    public function addExtraHttp($key, $value);

    /**
     * Remove extra meta attribute http-equiv by key.
     *
     * @param string $key
     */
    public function removeExtraHttp($key);

    /**
     * Get extra names.
     *
     * @return array
     */
    public function getExtraNames();

    /**
     * Set extra names.
     *
     * @param array $extraNames
     *
     * @return SeoMetadataInterface
     */
    public function setExtraNames(array $extraNames);

    /**
     * Add a key-value pair for meta attribute name.
     *
     * @param string $key
     * @param string $value
     */
    public function addExtraName($key, $value);

    /**
     * Remove extra meta attribute name by key.
     *
     * @param string $key
     */
    public function removeExtraName($key);

    /**
     * Get extra properties.
     *
     * @return array
     */
    public function getExtraProperties();

    /**
     * Set extra properties.
     *
     * @param array $extraProperties
     *
     * @return SeoMetadataInterface
     */
    public function setExtraProperties(array $extraProperties);

    /**
     * Add a key-value pair for meta attribute property.
     *
     * @param string $key
     * @param string $value
     */
    public function addExtraProperty($key, $value);

    /**
     * Remove extra meta attribute property by key.
     *
     * @param string $key
     */
    public function removeExtraProperty($key);
}
