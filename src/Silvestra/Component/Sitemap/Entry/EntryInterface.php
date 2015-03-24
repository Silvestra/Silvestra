<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Entry;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 8:13 PM
 */
interface EntryInterface
{
    /**
     * Get url.
     *
     * @return string
     */
    public function getLoc();

    /**
     * Get last mod.
     *
     * @return string
     */
    public function getLastMod();
}
