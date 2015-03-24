<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Dumper;

use Silvestra\Component\Sitemap\Profile\ProfileInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 7:47 PM
 */
interface DumperInterface
{

    /**
     * Dump all sitemap content.
     *
     * @param ProfileInterface $profile
     */
    public function dump(ProfileInterface $profile);
}
