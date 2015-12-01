<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo\Templating;

use Silvestra\Component\Seo\SeoPageInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/22/14 1:51 AM
 */
class SeoEngine implements SeoEngineInterface
{
    /**
     * @var string
     */
    private $encoding;

    /**
     * @var SeoPageInterface
     */
    private $seoPage;

    /**
     * Constructor.
     *
     * @param string $encoding
     * @param SeoPageInterface $seoPage
     */
    public function __construct($encoding, SeoPageInterface $seoPage)
    {
        $this->encoding = $encoding;
        $this->seoPage = $seoPage;
    }

    /**
     * {@inheritdoc}
     */
    public function renderHeadAttributes()
    {
        $headAttributes = '';
        foreach ($this->seoPage->getHeadAttributes() as $name => $value) {
            $headAttributes .= sprintf('%s="%s" ', $name, $value);
        }

        return rtrim($headAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function renderHtmlAttributes()
    {
        $htmlAttributes = '';
        foreach ($this->seoPage->getHtmlAttributes() as $name => $value) {
            $htmlAttributes .= sprintf('%s="%s" ', $name, $value);
        }

        return rtrim($htmlAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function renderLangAlternates()
    {
        $langAlternatives = '';
        foreach ($this->seoPage->getLangAlternates() as $href => $hrefLang) {
            $langAlternatives .= sprintf("<link rel=\"alternate\" href=\"%s\" hreflang=\"%s\" />\n", $href, $hrefLang);
        }

        return $langAlternatives;
    }

    /**
     * {@inheritdoc}
     */
    public function renderLinkCanonical()
    {
        if ($this->seoPage->getLinkCanonical()) {
            return sprintf("<link rel=\"canonical\" href=\"%s\" />\n", $this->seoPage->getLinkCanonical());
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function renderLinks()
    {
        $links = '';
        foreach ($this->seoPage->getLinks() as $rel => $href) {
            $links .= sprintf("<link rel=\"%s\" href=\"%s\" />\n", $rel, $href);
        }

        return $links;
    }

    /**
     * {@inheritdoc}
     */
    public function renderMeta()
    {
        $meta = '';
        foreach ($this->seoPage->getMetas() as $type => $metadatas) {
            foreach ((array) $metadatas as $name => $metadata) {
                list($content, $extras) = $metadata;

                $name = $this->normalize($name);
                if (false === empty($content)) {
                    $meta .= sprintf("<meta %s=\"%s\" content=\"%s\" />\n", $type, $name, $this->normalize($content));
                } else {
                    $meta .= sprintf("<meta %s=\"%s\" />\n", $type, $name);
                }
            }
        }

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function renderTitle()
    {
        return sprintf("<title>%s</title>\n", strip_tags($this->seoPage->getTitle()));
    }

    /**
     * Normalize string.
     *
     * @param string $string
     *
     * @return string
     */
    private function normalize($string)
    {
        return str_replace("'", '', str_replace('"', '', strip_tags($string)));
    }
}
