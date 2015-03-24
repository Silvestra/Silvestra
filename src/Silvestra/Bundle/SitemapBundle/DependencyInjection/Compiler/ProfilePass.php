<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SitemapBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 10:13 PM
 */
class ProfilePass implements CompilerPassInterface
{

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('silvestra_sitemap.registry.profile')) {
            return null;
        }

        $definition = $container->getDefinition('silvestra_sitemap.registry.profile');

        foreach ($container->findTaggedServiceIds('silvestra_sitemap.profile') as $id => $tags) {
            $definition->addMethodCall('add', array(new Reference($id)));
        }
    }
}
