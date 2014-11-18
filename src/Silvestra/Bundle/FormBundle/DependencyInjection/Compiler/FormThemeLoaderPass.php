<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\FormBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/10/14 12:21 AM
 */
class FormThemeLoaderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $formThemes = $container->getParameter('twig.form.resources');
        $formThemes[] = 'SilvestraFormBundle::form.html.twig';

        $container->setParameter('twig.form.resources', $formThemes);
    }
}
