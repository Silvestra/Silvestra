<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo;

use Silvestra\Component\Seo\Exception\RuntimeException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/7/14 9:57 PM
 */
class SeoPage implements SeoPageInterface
{
    /**
     * @var array
     */
    protected $headAttributes = array();

    /**
     * @var array
     */
    protected $htmlAttributes = array();

    /**
     * @var array
     */
    protected $langAlternates = array();

    /**
     * @var string
     */
    protected $linkCanonical;

    /**
     * @var array
     */
    protected $metas;

    /**
     * @var string
     */
    protected $separator;

    /**
     * @var string
     */
    protected $title;

    /**
     * Constructor.
     *
     * @param string $title
     * @param string $separator
     */
    public function __construct($title = '', $separator = ' | ')
    {
        $this->title = $title;
        $this->separator = $separator;
        $this->metas = array(
            'http-equiv' => array(),
            'name' => array(),
            'schema' => array(),
            'charset' => array(),
            'property' => array(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function addHeadAttribute($name, $value)
    {
        $this->headAttributes[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeadAttributes(array $attributes)
    {
        $this->headAttributes = $attributes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeadAttributes()
    {
        return $this->headAttributes;
    }

    /**
     * {@inheritdoc}
     */
    public function addHtmlAttributes($name, $value)
    {
        $this->htmlAttributes[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function setHtmlAttributes(array $attributes)
    {
        $this->htmlAttributes = $attributes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHtmlAttributes()
    {
        return $this->htmlAttributes;
    }

    /**
     * {@inheritdoc}
     */
    public function addLangAlternate($href, $hrefLang)
    {
        $this->langAlternates[$href] = $hrefLang;
    }

    /**
     * {@inheritdoc}
     */
    public function setLangAlternates(array $langAlternates)
    {
        $this->langAlternates = $langAlternates;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLangAlternates()
    {
        return $this->langAlternates;
    }

    /**
     * {@inheritdoc}
     */
    public function setLinkCanonical($linkCanonical)
    {
        $this->linkCanonical = $linkCanonical;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinkCanonical()
    {
        return $this->linkCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetas()
    {
        return $this->metas;
    }

    /**
     * {@inheritdoc}
     */
    public function addMeta($type, $name, $content, array $extras = array())
    {
        if (!isset($this->metas[$type])) {
            $this->metas[$type] = array();
        }

        $this->metas[$type][$name] = array($content, $extras);
    }

    /**
     * {@inheritdoc}
     */
    public function setMetas(array $metas)
    {
        $this->metas = array();

        foreach ($metas as $type => $metadata) {
            if (!is_array($metadata)) {
                throw new RuntimeException(sprintf('%s must be an array', $metadata));
            }

            foreach ($metadata as $name => $meta) {
                list($content, $extras) = $this->normalizeMeta($meta);

                $this->addMeta($type, $name, $content, $extras);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addTitle($title)
    {
        $this->title = $title . $this->separator . $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return rtrim($this->title, $this->separator);
    }

    /**
     * Normalize meta.
     *
     * @param mixed $meta
     *
     * @return array
     */
    private function normalizeMeta($meta)
    {
        if (is_string($meta)) {
            return array($meta, array());
        }

        return $meta;
    }
}
