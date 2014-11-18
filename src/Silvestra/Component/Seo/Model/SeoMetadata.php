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
class SeoMetadata implements SeoMetadataInterface
{
    /**
     * @var string
     */
    protected $lang;

    /**
     * @var string
     */
    protected $metaDescription;

    /**
     * @var string
     */
    protected $metaKeywords;

    /**
     * @var string
     */
    protected $metaRobots;

    /**
     * @var string
     */
    protected $originalUrl;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $extraHttp;

    /**
     * @var array
     */
    protected $extraNames;

    /**
     * @var array
     */
    protected $extraProperties;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->extraHttp = array();
        $this->extraNames = array();
        $this->extraProperties = array();
    }

    /**
     * {@inheritdoc}
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaRobots($metaRobots)
    {
        $this->metaRobots = $metaRobots;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaRobots()
    {
        return $this->metaRobots;
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginalUrl($originalUrl)
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalUrl()
    {
        return $this->originalUrl;
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
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtraHttp()
    {
        return $this->extraHttp;
    }

    /**
     * {@inheritdoc}
     */
    public function setExtraHttp(array $extraHttp)
    {
        $this->extraHttp = $extraHttp;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addExtraHttp($key, $value)
    {
        $this->extraHttp[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function removeExtraHttp($key)
    {
        if (isset($this->extraHttp[$key])) {
            unset($this->extraHttp[$key]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getExtraNames()
    {
        return $this->extraNames;
    }

    /**
     * {@inheritdoc}
     */
    public function addExtraName($key, $value)
    {
        $this->extraNames[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function removeExtraName($key)
    {
        if (isset($this->extraNames[$key])) {
            unset($this->extraNames[$key]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setExtraNames(array $extraNames)
    {
        $this->extraNames = $extraNames;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtraProperties()
    {
        return $this->extraProperties;
    }

    /**
     * {@inheritdoc}
     */
    public function setExtraProperties(array $extraProperties)
    {
        $this->extraProperties = $extraProperties;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addExtraProperty($key, $value)
    {
        $this->extraProperties[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function removeExtraProperty($key)
    {
        if (isset($this->extraProperties[$key])) {
            unset($this->extraProperties[$key]);
        }
    }
}
