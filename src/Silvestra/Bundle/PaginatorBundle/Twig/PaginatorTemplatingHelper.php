<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\PaginatorBundle\Twig;

use Silvestra\Component\Paginator\Pagination;
use Silvestra\Component\Paginator\Request\PaginatorTemplatingHelperInterface;
use Silvestra\Component\Paginator\Url\UrlHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\Helper\Helper as TemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 15.3.4 15.57
 */
class PaginatorTemplatingHelper extends TemplatingHelper implements PaginatorTemplatingHelperInterface
{

    /**
     * @var string
     */
    private $template;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * Constructor.
     *
     * @param string $template
     * @param \Twig_Environment $twig
     * @param UrlHelper $urlHelper
     */
    public function __construct($template, \Twig_Environment $twig, UrlHelper $urlHelper)
    {
        $this->template = $template;
        $this->twig = $twig;
        $this->urlHelper = $urlHelper;
    }


    /**
     * {@inheritdoc}
     */
    public function getPath(Request $request, $routeName = null, array $parameters = array())
    {
        return $this->urlHelper->getRelativeUrl($request, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function render(Pagination $pagination, array $parameters = array(), $template = null)
    {
        if (null === $template) {
            $template = $this->template;
        }

        return $this->twig->render($template, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_paginator';
    }
}
