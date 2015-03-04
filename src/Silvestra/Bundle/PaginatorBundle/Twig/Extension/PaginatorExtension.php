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

use Silvestra\Bundle\PaginatorBundle\Twig\PaginatorTemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 15.3.4 15.57
 */
class PaginatorExtension extends \Twig_Extension
{
    /**
     * @var PaginatorTemplatingHelper
     */
    private $helper;

    /**
     * Constructor.
     *
     * @param PaginatorTemplatingHelper $helper
     */
    public function __construct(PaginatorTemplatingHelper $helper)
    {
        $this->helper = $helper;
    }


    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'silvestra_paginator_path',
                array($this->helper, 'getPath')
            ),
            new \Twig_SimpleFunction(
                'silvestra_paginator_render',
                array($this->helper, 'renderPagination'),
                array('is_safe' => array('html'))
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
