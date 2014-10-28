<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Site\Model;

use Silvestra\Component\Seo\Model\SeoMetadataInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface SiteInterface
{

    /**
     * Set domain.
     *
     * @param string $domain
     *
     * @return SiteInterface
     */
    public function setDomain($domain);

    /**
     * Get domain.
     *
     * @return string
     */
    public function getDomain();

    /**
     * Set seoMetadata.
     *
     * @param array|SeoMetadataInterface[] $seoMetadata
     *
     * @return SiteInterface
     */
    public function setSeoMetadata($seoMetadata);

    /**
     * Get seoMetadata.
     *
     * @return array|SeoMetadataInterface[]
     */
    public function getSeoMetadata();

    /**
     * Add seoMetadata.
     *
     * @param SeoMetadataInterface $seoMetadata
     */
    public function addSeoMetadata(SeoMetadataInterface $seoMetadata);

    /**
     * Remove seoMetadata.
     *
     * @param SeoMetadataInterface $seoMetadata
     */
    public function removeSeoMetadata(SeoMetadataInterface $seoMetadata);

    /**
     * Get seoMetadata by language.
     *
     * @param string $lang
     *
     * @return null|SeoMetadataInterface
     */
    public function getSeoMetadataByLang($lang);

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return SiteInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();
}
