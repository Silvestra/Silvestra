<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Locale\Templating;

use Symfony\Component\Templating\Helper\Helper as TemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/7/14 10:47 PM
 */
class LocaleTemplatingHelper extends TemplatingHelper implements LocaleTemplatingHelperInterface
{

    /**
     * {@inheritdoc}
     */
    public function getLocaleDisplayName($locale)
    {
        return \Locale::getDisplayName($locale);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_locale';
    }
}
