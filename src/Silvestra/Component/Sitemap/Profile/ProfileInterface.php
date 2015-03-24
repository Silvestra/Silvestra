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

use Silvestra\Component\Sitemap\Entry\EntryInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 8:09 PM
 */
interface ProfileInterface
{
    /**
     * Get entries.
     *
     * @return array|EntryInterface[]
     */
    public function getEntries();

    /**
     * Get sitemap xml name.
     *
     * @return string
     */
    public function getName();
}
