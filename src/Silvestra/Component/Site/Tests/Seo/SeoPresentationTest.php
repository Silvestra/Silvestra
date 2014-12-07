<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Site\Tests\Seo;

use Silvestra\Component\Seo\Model\SeoMetadata;
use Silvestra\Component\Seo\SeoPage;
use Silvestra\Component\Site\Seo\SeoPresentation;
use Silvestra\Component\Site\Model\Site;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/11/14 11:26 PM
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
        $siteManager = $this->getMock('Silvestra\\Component\\Site\\Model\\Manager\\SiteManagerInterface');

        $site = new Site();
        $seoMetadata = new SeoMetadata();

        $seoMetadata->setLang('en');
        $seoMetadata->setTitle('Silvestra');
        $site->addSeoMetadata($seoMetadata);
        $siteManager->method('find')->will($this->returnValue($site));

        $this->seoPresentation = new SeoPresentation('UTF-8', $this->seoPage, $siteManager);
    }

    public function testUpdateSeoPage()
    {
        $seoMetadata = new SeoMetadata();

        $seoMetadata->setLang('en');
        $seoMetadata->setTitle('Next page');
        $this->seoPresentation->updateSeoPage($seoMetadata);

        $this->assertEquals('Next page | Silvestra', $this->seoPage->getTitle());
    }
}
