<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo\Model;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
interface AlternateLanguageInterface
{
    /**
     * Get href.
     *
     * @return string
     */
    public function getHref();

    /**
     * Set href.
     *
     * @param string $href
     *
     * @return AlternateLanguageInterface
     */
    public function setHref($href);

    /**
     * Get href language.
     *
     * @return string
     */
    public function getHrefLang();

    /**
     * Set href language.
     *
     * @param string $hrefLang
     *
     * @return AlternateLanguageInterface
     */
    public function setHrefLang($hrefLang);
}
