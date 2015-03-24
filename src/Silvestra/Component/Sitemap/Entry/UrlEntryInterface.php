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
 * @since 3/24/15 7:57 PM
 */
interface UrlEntryInterface extends EntryInterface
{

    /**
     * Get change freq.
     *
     * @return string
     */
    public function getChangeFreq();

    /**
     * Get priority
     *
     * @return float
     */
    public function getPriority();
}
