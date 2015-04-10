<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo\Tests\Templating;

use Silvestra\Component\Seo\SeoPage;
use Silvestra\Component\Seo\Templating\SeoEngine;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/9/14 1:03 PM
 */
class SeoEngineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SeoEngine
     */
    private $seoEngine;

    /**
     * @var SeoPage
     */
    private $seoPage;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->seoPage = new SeoPage();
        $this->seoEngine = new SeoEngine('UTF-8', $this->seoPage);
    }

    /**
     * Test method: renderHeadAttributes().
     */
    public function testRenderHeadAttributes()
    {
        $this->assertEquals('', $this->seoEngine->renderHeadAttributes());

        $this->seoPage->addHeadAttribute('test', 'test');

        $this->assertEquals('test="test"', $this->seoEngine->renderHeadAttributes());
    }

    /**
     * Test method: renderHtmlAttributes().
     */
    public function testRenderHtmlAttributes()
    {
        $this->assertEquals('', $this->seoEngine->renderHtmlAttributes());

        $this->seoPage->addHtmlAttributes('lang', 'en');

        $this->assertEquals('lang="en"', $this->seoEngine->renderHtmlAttributes());
    }

    /**
     * Test method: renderLangAlternates().
     */
    public function testRenderLangAlternates()
    {
        $this->assertEquals('', $this->seoEngine->renderLangAlternates());

        $this->seoPage->addLangAlternate('www.silvestra/en', 'en');

        $enAlternative = "<link rel=\"alternate\" href=\"www.silvestra/en\" hreflang=\"en\"/>\n";

        $this->assertEquals(
            $enAlternative,
            $this->seoEngine->renderLangAlternates()
        );

        $this->seoPage->addLangAlternate('www.silvestra/lt', 'lt');

        $this->assertEquals(
            $enAlternative . "<link rel=\"alternate\" href=\"www.silvestra/lt\" hreflang=\"lt\"/>\n",
            $this->seoEngine->renderLangAlternates()
        );
    }

    /**
     * Test method: renderLinkCanonical().
     */
    public function testRenderLinkCanonical()
    {
        $this->assertEquals('', $this->seoEngine->renderLinkCanonical());

        $this->seoPage->setLinkCanonical('www.silvestra');

        $this->assertEquals(
            "<link rel=\"canonical\" href=\"www.silvestra\"/>\n",
            $this->seoEngine->renderLinkCanonical()
        );
    }

    /**
     * Test method: renderLinks().
     */
    public function testRenderLinks()
    {
        $this->assertEquals('', $this->seoEngine->renderLinks());

        $this->seoPage->addLink('prev', 'www.silvestra?page=1');
        $this->seoPage->addLink('next', 'www.silvestra?page=3');

        $this->assertEquals(
            "<link rel=\"prev\" href=\"www.silvestra?page=1\"/>\n<link rel=\"next\" href=\"www.silvestra?page=3\"/>\n",
            $this->seoEngine->renderLinks()
        );
    }

    /**
     * Test method: renderMeta().
     */
    public function testRenderMeta()
    {
        $this->assertEquals('', $this->seoEngine->renderMeta());

        $this->seoPage->addMeta('name', 'description', 'Silvestra description.');

        $metaDescription = "<meta name=\"description\" content=\"Silvestra description.\">\n";
        $this->assertEquals(
            $metaDescription,
            $this->seoEngine->renderMeta()
        );

        $this->seoPage->addMeta('name', 'keywords', 'Silvestra, SEO');

        $metaKeywords = "<meta name=\"keywords\" content=\"Silvestra, SEO\">\n";

        $this->assertEquals($metaDescription . $metaKeywords, $this->seoEngine->renderMeta());

        $this->seoPage->addMeta('charset', 'UTF-8', '');

        $this->assertEquals(
            $metaDescription . $metaKeywords . "<meta charset=\"UTF-8\">\n",
            $this->seoEngine->renderMeta()
        );
    }

    /**
     * Test method: renderTitle().
     */
    public function testRenderTitle()
    {
        $this->assertEquals("<title></title>\n", $this->seoEngine->renderTitle());

        $this->seoPage->addTitle('Silvestra');

        $this->assertEquals("<title>Silvestra</title>\n", $this->seoEngine->renderTitle());

        $this->seoPage->addTitle('Home');

        $this->assertEquals("<title>Home | Silvestra</title>\n", $this->seoEngine->renderTitle());
    }
}
