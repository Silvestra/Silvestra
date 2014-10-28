<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SiteBundle\Model;

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
     * @param SeoMetadataInterface $seoMetadata
     *
     * @return SiteInterface
     */
    public function setSeoMetadata(SeoMetadataInterface $seoMetadata);

    /**
     * Get seoMetadata.
     *
     * @return SeoMetadataInterface
     */
    public function getSeoMetadata();

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return SiteInterface
     */
    public function setCreatedAt(\DateTime $createdAt);

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
