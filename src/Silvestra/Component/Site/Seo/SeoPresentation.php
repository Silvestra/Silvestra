<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Site\Seo;

use Silvestra\Component\Seo\Model\SeoMetadataInterface;
use Silvestra\Component\Seo\SeoPageInterface;
use Silvestra\Component\Seo\SeoPresentation as BaseSeoPresentation;
use Silvestra\Component\Site\Model\Manager\SiteManagerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/11/14 11:16 PM
 */
class SeoPresentation extends BaseSeoPresentation
{
    /**
     * @var SiteManagerInterface
     */
    private $siteManager;

    /**
     * Constructor.
     *
     * @param string $encoding
     * @param SeoPageInterface $seoPage
     * @param SiteManagerInterface $siteManager
     */
    public function __construct($encoding, SeoPageInterface $seoPage, SiteManagerInterface $siteManager)
    {
        parent::__construct($encoding, $seoPage);

        $this->siteManager = $siteManager;
    }

    /**
     * {@inheritdoc}
     */
    public function updateSeoPage(SeoMetadataInterface $seoMetadata)
    {
        $site = $this->siteManager->find();

        if ((null !== $site) && (null !== $siteSeoMetadata = $site->getSeoMetadataByLang($seoMetadata->getLang()))) {
            $this->seoPage->setTitle($siteSeoMetadata->getTitle());
        }

        parent::updateSeoPage($seoMetadata);
    }
}
