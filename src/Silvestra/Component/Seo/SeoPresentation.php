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

        if ($description = $seoMetadata->getMetaDescription()) {
            $this->seoPage->addMeta('name', 'description', $description);
        }

        if ($extraHttp = $seoMetadata->getExtraHttp()) {
            $this->addMetas('http-equiv', $extraHttp);
        }

        if ($extraNames = $seoMetadata->getExtraNames()) {
            $this->addMetas('name', $extraNames);
        }

        if ($extraProperties = $seoMetadata->getExtraProperties()) {
            $this->addMetas('property', $extraProperties);
        }

        if ($keywords = $seoMetadata->getMetaKeywords()) {
            $this->seoPage->addMeta('name', 'keywords', $keywords);
        }

        if ($robots = $seoMetadata->getMetaRobots()) {
            $this->seoPage->addMeta('name', 'robots', $robots);
        }

        if ($title = $seoMetadata->getTitle()) {
            $this->addTitle($title);
        }
    }

    /**
     * Add metas.
     *
     * @param string $type
     * @param array $values
     */
    private function addMetas($type, array $values)
    {
        foreach ($values as $key => $value) {
            $this->seoPage->addMeta($type, $key, $value);
        }
    }

    /**
     * Add title.
     *
     * @param string $title
     */
    private function addTitle($title)
    {
        $this->seoPage->addTitle($title);
        $this->seoPage->addMeta('name', 'title', $title);
    }
}
