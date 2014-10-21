<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SeoBundle\Twig\Extension;

use Silvestra\Component\Seo\Templating\SeoEngineInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/22/14 1:43 AM
 */
class SeoExtension extends \Twig_Extension
{
    /**
     * @var SeoEngineInterface
     */
    private $seoEngine;

    /**
     * Constructor.
     *
     * @param SeoEngineInterface $seoEngine
     */
    public function __construct(SeoEngineInterface $seoEngine)
    {
        $this->seoEngine = $seoEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'silvestra_seo_head_attributes',
                array($this->seoEngine, 'renderHeadAttributes'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFunction('silvestra_seo_html_attributes', array(
                $this->seoEngine,
                'renderHtmlAttributes'
            ), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('silvestra_seo_lang_alternates', array(
                $this->seoEngine,
                'renderLangAlternates'
            ), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('silvestra_seo_link_canonical', array(
                $this->seoEngine,
                'renderLinkCanonical'
            ), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('silvestra_seo_meta', array(
                $this->seoEngine,
                'renderMeta'
            ), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('silvestra_seo_title', array(
                $this->seoEngine,
                'renderTitle'
            ), array('is_safe' => array('html'))),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_seo';
    }
}
