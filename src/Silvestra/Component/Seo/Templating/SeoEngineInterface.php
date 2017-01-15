<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo\Templating;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface SeoEngineInterface
{
    /**
     * Render head attributes.
     *
     * @return string
     */
    public function renderHeadAttributes();

    /**
     * Render html attributes.
     *
     * @return string
     */
    public function renderHtmlAttributes();

    /**
     * Render language alternatives.
     *
     * @return string
     */
    public function renderLangAlternates();

    /**
     * Render link canonical.
     *
     * @return string
     */
    public function renderLinkCanonical();

    /**
     * Render links.
     *
     * @return string
     */
    public function renderLinks();

    /**
     * Render meta.
     *
     * @return string
     */
    public function renderMeta();

    /**
     * Render title.
     *
     * @return string
     */
    public function renderTitle();
}
