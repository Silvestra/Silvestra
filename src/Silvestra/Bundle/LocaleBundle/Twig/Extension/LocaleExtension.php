<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\LocaleBundle\Twig\Extension;

use Silvestra\Component\Locale\Templating\LocaleTemplatingHelperInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/7/14 10:51 PM
 */
class LocaleExtension extends \Twig_Extension
{
    /**
     * @var LocaleTemplatingHelperInterface
     */
    private $localeHelper;

    /**
     * Constructor.
     *
     * @param LocaleTemplatingHelperInterface $localeHelper
     */
    public function __construct(LocaleTemplatingHelperInterface $localeHelper)
    {
        $this->localeHelper = $localeHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'silvestra_locale_display_name',
                array($this->localeHelper, 'getLocaleDisplayName'),
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_locale';
    }
}
