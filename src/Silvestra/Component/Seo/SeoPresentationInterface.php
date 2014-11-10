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
 * @since 11/9/14 12:18 PM
 */
interface SeoPresentationInterface
{
    /**
     * Update seo page.
     *
     * @param SeoMetadataInterface $seoMetadata
     */
    public function updateSeoPage(SeoMetadataInterface $seoMetadata);
}
