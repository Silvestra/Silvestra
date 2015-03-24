<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Profile;

use Silvestra\Component\Sitemap\Entry\SitemapEntryInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 9:32 PM
 */
class SitemapIndexProfile implements ProfileInterface
{
    /**
     * @var array|SitemapEntryInterface[]
     */
    private $entries;

    /**
     * Constructor.
     *
     * @param array|SitemapEntryInterface[] $entries
     */
    public function __construct(array $entries)
    {
        $this->entries = $entries;
    }

    /**
     * Get entries.
     *
     * @return array|SitemapEntryInterface[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Get sitemap xml name.
     *
     * @return string
     */
    public function getName()
    {
        return 'sitemap.xml';
    }
}
