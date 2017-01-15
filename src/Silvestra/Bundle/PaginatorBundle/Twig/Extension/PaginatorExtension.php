<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\PaginatorBundle\Twig\Extension;

use Silvestra\Bundle\PaginatorBundle\Twig\TwigTemplatingHelper;
use Silvestra\Component\Paginator\UrlHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class PaginatorExtension extends \Twig_Extension
{

    /**
     * @var TwigTemplatingHelper
     */
    private $twigHelper;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * Constructor.
     *
     * @param TwigTemplatingHelper $twigHelper
     * @param UrlHelper $urlHelper
     */
    public function __construct(TwigTemplatingHelper $twigHelper, UrlHelper $urlHelper)
    {
        $this->twigHelper = $twigHelper;
        $this->urlHelper = $urlHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'silvestra_paginator_render',
                array($this->twigHelper, 'render'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFunction(
                'silvestra_paginator_path',
                array($this->urlHelper, 'getRelativeUrl')
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_paginator';
    }
}
