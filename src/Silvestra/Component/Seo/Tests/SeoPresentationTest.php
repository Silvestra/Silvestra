<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo\Tests;

use Silvestra\Component\Seo\Model\SeoMetadata;
use Silvestra\Component\Seo\SeoPage;
use Silvestra\Component\Seo\SeoPresentation;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class SeoPresentationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SeoPage
     */
    private $seoPage;

    /**
     * @var SeoPresentation
     */
    private $seoPresentation;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->seoPage = new SeoPage();
        $this->seoPresentation = new SeoPresentation('UTF-8', $this->seoPage);
    }

    public function testUpdateSeoPageWithEmptySeoMetadata()
    {
        $seoMetadata = new SeoMetadata();

        $this->seoPresentation->updateSeoPage($seoMetadata);

        $this->assertEquals(array('lang' => ''), $this->seoPage->getHtmlAttributes());
        $this->assertEmpty($this->seoPage->getHeadAttributes());
        $this->assertEmpty($this->seoPage->getLangAlternates());
        $this->assertEmpty($this->seoPage->getLinkCanonical());
        $this->assertEquals(
            array(
                'http-equiv' => array(),
                'name' => array(),
                'schema' => array(),
                'charset' => array('UTF-8' => array('', array())),
                'property' => array()
            ),
            $this->seoPage->getMetas()
        );
        $this->assertEmpty($this->seoPage->getTitle());
    }

    public function testUpdateSeoPage()
    {
        $seoMetadata = new SeoMetadata();
        $seoMetadata->setLang('en');
        $seoMetadata->setMetaDescription('Silvestra test.');
        $seoMetadata->setMetaKeywords('Silvestra, Test');
        $seoMetadata->setMetaRobots('NOINDEX, NOFOLLOW');
        $seoMetadata->setTitle('Silvestra');

        $this->seoPresentation->updateSeoPage($seoMetadata);

        $this->assertEquals(array('lang' => 'en'), $this->seoPage->getHtmlAttributes());
        $this->assertEmpty($this->seoPage->getHeadAttributes());
        $this->assertEmpty($this->seoPage->getLangAlternates());
        $this->assertEmpty($this->seoPage->getLinkCanonical());
        $this->assertEquals(
            array(
                'http-equiv' => array(),
                'name' => array(
                    'description' => array('Silvestra test.', array()),
                    'keywords' => array('Silvestra, Test', array()),
                    'robots' => array('NOINDEX, NOFOLLOW', array()),
                    'title' => array('Silvestra', array()),
                ),
                'schema' => array(),
                'charset' => array('UTF-8' => array('', array())),
                'property' => array()
            ),
            $this->seoPage->getMetas()
        );
        $this->assertEquals('Silvestra', $this->seoPage->getTitle());
    }
}
