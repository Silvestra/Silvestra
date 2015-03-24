<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Render;

use Silvestra\Component\Sitemap\Entry\SitemapEntryInterface;
use Silvestra\Component\Sitemap\Entry\UrlEntryInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 7:54 PM
 */
interface RenderInterface
{
    /**
     * Render sitemap xml.
     *
     * @param array|UrlEntryInterface[] $entries
     *
     * @return string
     */
    public function renderSitemap(array $entries);

    /**
     * Render sitemap index xml.
     *
     * @param array|SitemapEntryInterface[] $entries
     *
     * @return string
     */
    public function renderSitemapIndex(array $entries);
}
