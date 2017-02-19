<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Factory;

use Silvestra\Component\Seo\Model\Manager\SeoMetadataManagerInterface;
use Silvestra\Component\Seo\Model\SeoMetadataInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/22/15 8:08 PM
 */
class SeoFactory
{

    /**
     * @var SeoMetadataManagerInterface
     */
    private $seoMetadataManager;

    /**
     * Constructor.
     *
     * @param SeoMetadataManagerInterface $seoMetadataManager
     */
    public function __construct(SeoMetadataManagerInterface $seoMetadataManager)
    {
        $this->seoMetadataManager = $seoMetadataManager;
    }

    /**
     * Create node translation seo metadata.
     *
     * @param NodeTranslationInterface $translation
     *
     * @return SeoMetadataInterface
     */
    public function create(NodeTranslationInterface $translation)
    {
        $seoMetadata = $this->seoMetadataManager->create();
        $seoMetadata->setLang($translation->getLang());
        $seoMetadata->setTitle($translation->getTitle());

        $this->seoMetadataManager->add($seoMetadata);

        return $seoMetadata;
    }
}
