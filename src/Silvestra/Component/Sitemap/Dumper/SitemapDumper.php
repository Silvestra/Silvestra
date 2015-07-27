<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Dumper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/27/15 11:18 PM
 */
class SitemapDumper extends SitemapFileDumper
{

    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        $sitemapEntries = array();

        foreach ($this->registry->getProfiles() as $profile) {
            $sitemapEntries = array_merge($sitemapEntries, $this->getSitemapEntries($profile));
        }

        return $this->render->renderSitemapIndex($sitemapEntries);
    }
}
