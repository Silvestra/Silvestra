<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Locale\Templating;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/7/14 10:48 PM
 */
interface LocaleTemplatingHelperInterface
{
    /**
     * Get locale display name.
     *
     * @param string $locale
     *
     * @return string
     */
    public function getLocaleDisplayName($locale);
}
