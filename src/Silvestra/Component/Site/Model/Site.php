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
class Site implements SiteInterface
{

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var array|SeoMetadataInterface[]
     */
    protected $seoMetadata;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->seoMetadata = array();
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * {@inheritdoc}
     */
    public function setSeoMetadata($seoMetadata)
    {
        $this->seoMetadata = $seoMetadata;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSeoMetadata()
    {
        return $this->seoMetadata;
    }

    /**
     * {@inheritdoc}
     */
    public function addSeoMetadata(SeoMetadataInterface $seoMetadata)
    {
        $this->seoMetadata[] = $seoMetadata;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSeoMetadata(SeoMetadataInterface $seoMetadata)
    {
        // TODO
    }

    /**
     * {@inheritdoc}
     */
    public function getSeoMetadataByLang($lang)
    {
        foreach ($this->seoMetadata as $seoMetadata) {
            if ($lang === $seoMetadata->getLang()) {
                return $seoMetadata;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
