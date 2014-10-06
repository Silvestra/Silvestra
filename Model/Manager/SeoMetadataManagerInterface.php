<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo\Model\Manager;

use Silvestra\Component\Seo\Model\SeoMetadataInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface SeoMetadataManagerInterface
{
    /**
     * Create new SeoMetadata object.
     *
     * @return SeoMetadataInterface
     */
    public function create();

    /**
     * Add SeoMetadata object from persistent layer.
     *
     * @param SeoMetadataInterface $seoMetadata
     * @param bool $save
     */
    public function add(SeoMetadataInterface $seoMetadata, $save = false);

    /**
     * Remove SeoMetadata object from persistent layer.
     *
     * @param SeoMetadataInterface $seoMetadata
     * @param bool $save
     */
    public function remove(SeoMetadataInterface $seoMetadata, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear SeoMetadata objects from persistent layer.
     */
    public function clear();

    /**
     * Get SeoMetadata object class name.
     *
     * @return string
     */
    public function getClass();
}
