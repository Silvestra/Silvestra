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

use Silvestra\Component\Seo\Model\SeoMetadataInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/9/14 12:17 PM
 */
class SeoPresentation implements SeoPresentationInterface
{
    /**
     * @var string
     */
    protected $encoding;

    /**
     * @var SeoPageInterface
     */
    protected $seoPage;

    /**
     * Constructor.
     *
     * @param string $encoding
     * @param SeoPageInterface $seoPage
     */
    public function __construct($encoding, SeoPageInterface $seoPage)
    {
        $this->encoding = $encoding;
        $this->seoPage = $seoPage;
    }

    /**
     * {@inheritdoc}
     */
    public function updateSeoPage(SeoMetadataInterface $seoMetadata)
    {
        $this->seoPage->addHtmlAttributes('lang', $seoMetadata->getLang());

        $this->seoPage->addMeta('charset', $this->encoding, '');
        if ($seoMetadata->getMetaDescription()) {
            $this->seoPage->addMeta('name', 'description', $seoMetadata->getMetaDescription());
        }
        if ($seoMetadata->getMetaKeywords()) {
            $this->seoPage->addMeta('name', 'keywords', $seoMetadata->getMetaKeywords());
        }
        if ($seoMetadata->getMetaRobots()) {
            $this->seoPage->addMeta('name', 'robots', $seoMetadata->getMetaRobots());
        }

        $this->seoPage->addTitle($seoMetadata->getTitle());
    }
}
