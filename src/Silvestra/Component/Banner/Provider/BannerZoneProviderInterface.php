<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Provider;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/5/14 10:44 PM
 */
interface BannerZoneProviderInterface
{
    /**
     * Get banner zone config choices.
     *
     * @param string $slug
     *
     * @return array
     */
    public function getConfigChoices($slug);
}
