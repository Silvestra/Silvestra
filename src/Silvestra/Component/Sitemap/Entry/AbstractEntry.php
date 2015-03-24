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
 * @since 3/24/15 8:29 PM
 */
abstract class AbstractEntry implements EntryInterface
{

    /**
     * Normalize las mod.
     *
     * @param mixed $lastMod
     *
     * @return string|null
     */
    protected function normalizeLastMod($lastMod)
    {
        if ($lastMod instanceof \DateTime) {
            return $lastMod->format('Y-m-d');
        }

        return null;
    }
}
