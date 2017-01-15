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
class AlternateLanguage implements AlternateLanguageInterface
{
    /**
     * @var string
     */
    public $href;

    /**
     * @var string
     */
    public $hrefLang;

    /**
     * {@inheritdoc}
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * {@inheritdoc}
     */
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHrefLang()
    {
        return $this->hrefLang;
    }

    /**
     * {@inheritdoc}
     */
    public function setHrefLang($hrefLang)
    {
        $this->hrefLang = $hrefLang;

        return $this;
    }
}
