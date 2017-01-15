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
use Silvestra\Component\Paginator\TemplatingHelperInterface;
use Symfony\Component\Templating\Helper\Helper as TemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class TwigTemplatingHelper extends TemplatingHelper implements TemplatingHelperInterface
{

    /**
     * @var int
     */
    private $maxNearPages;

    /**
     * @var string
     */
    private $template;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Constructor.
     *
     * @param int $maxNearPages
     * @param string $template
     * @param \Twig_Environment $twig
     */
    public function __construct($maxNearPages, $template, \Twig_Environment $twig)
    {
        $this->maxNearPages = $maxNearPages;
        $this->template = $template;
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function render(Pagination $pagination, array $parameters = array(), $template = null)
    {
        if (1 >= $pagination->getPageCount()) {
            return '';
        }

        if (null === $template) {
            $template = $this->template;
        }

        $parameters['pagination'] = $pagination;

        if (false === isset($parameters['max_near_pages'])) {
            $parameters['max_near_pages'] = $this->maxNearPages;
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
