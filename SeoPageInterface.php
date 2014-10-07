<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/7/14 9:56 PM
 */
interface SeoPageInterface
{
    /**
     * Add head attribute.
     *
     * @param string $name
     * @param string $value
     */
    public function addHeadAttribute($name, $value);

    /**
     * Set head attributes.
     *
     * @param array $attributes
     *
     * @return SeoPageInterface
     */
    public function setHeadAttributes(array $attributes);

    /**
     * Get head attributes.
     *
     * @return array
     */
    public function getHeadAttributes();

    /**
     * Add html attributes.
     *
     * @param string $name
     * @param string $value
     */
    public function addHtmlAttributes($name, $value);

    /**
     * Set html attributes.
     *
     * @param array $attributes
     *
     * @return SeoPageInterface
     */
    public function setHtmlAttributes(array $attributes);

    /**
     * Get html attributes.
     *
     * @return array
     */
    public function getHtmlAttributes();

    /**
     * Add language alternate.
     *
     * @param string $href
     * @param string $hrefLang
     */
    public function addLangAlternate($href, $hrefLang);

    /**
     * Set language alternatives.
     *
     * @param array $langAlternates
     *
     * @return SeoPageInterface
     */
    public function setLangAlternates(array $langAlternates);

    /**
     * Get language alternatives.
     *
     * @return array
     */
    public function getLangAlternates();

    /**
     * Set link canonical.
     *
     * @param string $linkCanonical
     *
     * @return SeoPageInterface
     */
    public function setLinkCanonical($linkCanonical);

    /**
     * Get link canonical.
     *
     * @return string
     */
    public function getLinkCanonical();

    /**
     * Add meta.
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param array  $extras
     */
    public function addMeta($type, $name, $value, array $extras = array());

    /**
     * Set metas.
     *
     * @param array $metas
     *
     * @return SeoPageInterface
     */
    public function setMetas(array $metas);

    /**
     * Get metas.
     *
     * @return array
     */
    public function getMetas();

    /**
     * Set separator.
     *
     * @param string $separator
     *
     * @return SeoPageInterface
     */
    public function setSeparator($separator);

    /**
     * Add title.
     *
     * @param string $title
     */
    public function addTitle($title);

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return SeoPageInterface
     */
    public function setTitle($title);

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle();
}
