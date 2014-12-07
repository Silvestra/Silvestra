<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Locale\Helper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/6/14 4:28 PM
 */
class LocaleHelper
{
    /**
     * @var array
     */
    private $allowedLocales;

    /**
     * Constructor.
     *
     * @param array $allowedLocales
     */
    public function __construct(array $allowedLocales)
    {
        $this->allowedLocales = $allowedLocales;
    }

    /**
     * Get display locales.
     *
     * @return array
     */
    public function getDisplayLocales()
    {
        $locales = array();

        foreach ($this->allowedLocales as $locale) {
            $locales[$locale] = \Locale::getDisplayName($locale);
        }

        return $locales;
    }
}
