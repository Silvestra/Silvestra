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
class XmlRender implements RenderInterface
{

    /**
     * Render sitemap xml.
     *
     * @param array|UrlEntryInterface[] $entries
     *
     * @return string
     */
    public function renderSitemap(array $entries)
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $data .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        foreach ($entries as $entry) {
            $data .= '    <url>' . PHP_EOL;
            $data .= '        <loc>' . $entry->getLoc() . '</loc>' . PHP_EOL;
            if (null !== $entry->getLastMod()) {
                $data .= '        <lastmod>' . $entry->getLastMod() . '</lastmod>' . PHP_EOL;
            }
            if (null !== $entry->getChangeFreq()) {
                $data .= '        <changefreq>' . $entry->getChangeFreq() . '</changefreq>' . PHP_EOL;
            }
            if (null !== $entry->getPriority()) {
                $data .= '        <priority>' . $entry->getPriority() . '</priority>' . PHP_EOL;
            }
            $data .= '    </url>' . PHP_EOL;
        }

        $data .= '</urlset>' . PHP_EOL;

        return $data;
    }

    /**
     * Render sitemap index xml.
     *
     * @param array|SitemapEntryInterface[] $entries
     *
     * @return string
     */
    public function renderSitemapIndex(array $entries)
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $data .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        foreach ($entries as $entry) {
            $data .= '    <sitemap>' . PHP_EOL;
            $data .= '        <loc>' . $entry->getLoc() . '</loc>' . PHP_EOL;
            $data .= '        <lastmod>' . $entry->getLastMod() . '</lastmod>' . PHP_EOL;
            $data .= '    </sitemap>' . PHP_EOL;
        }

        $data .= '</sitemapindex>' . PHP_EOL;

        return $data;
    }
}
