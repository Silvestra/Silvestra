<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Tests\Render;

use PHPUnit_Framework_TestCase as TestCase;
use Silvestra\Component\Sitemap\Entry\SitemapEntry;
use Silvestra\Component\Sitemap\Entry\UrlEntry;
use Silvestra\Component\Sitemap\Render\XmlRender;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 11:14 PM
 */
class XmlRenderTest extends TestCase
{
    /**
     * @var XmlRender
     */
    private $render;

    protected function setUp()
    {
        $this->render = new XmlRender();
    }

    public function testRenderSitemap_Empty()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
</urlset>

EOF;

        $this->assertEquals($xml, $this->render->renderSitemap(array()));
    }

    public function testRenderSitemapIndex_Empty()
    {
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
</sitemapindex>

EOF;

        $this->assertEquals($xml, $this->render->renderSitemapIndex(array()));
    }

    public function testRenderSitemap_WithEntries()
    {
        $entries = array(new UrlEntry('www.silvestra.org', new \DateTime('2015-03-03'), 'weekly', 0.6));
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>www.silvestra.org</loc>
        <lastmod>2015-03-03</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
</urlset>

EOF;

        $this->assertEquals($xml, $this->render->renderSitemap($entries));
    }

    public function testRenderSitemapIndex_WithEntries()
    {
        $entries = array(new SitemapEntry('www.silvestra.org', new \DateTime('2015-03-03')));
        $xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>www.silvestra.org</loc>
        <lastmod>2015-03-03</lastmod>
    </sitemap>
</sitemapindex>

EOF;

        $this->assertEquals($xml, $this->render->renderSitemapIndex($entries));
    }
}
