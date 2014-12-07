<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\BannerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/5/14 10:30 PM
 */
class BannerZoneRegistryPass implements CompilerPassInterface
{

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('silvestra_banner.registry.banner_zone')) {
            return null;
        }

        $definition = $container->getDefinition('silvestra_banner.registry.banner_zone');
        $calls = $definition->getMethodCalls();

        $definition->setMethodCalls(array());
        foreach ($container->findTaggedServiceIds('silvestra_banner_zone') as $id => $attributes) {
            $definition->addMethodCall('addConfig', array(new Reference($id)));
        }
        $definition->setMethodCalls(array_merge($definition->getMethodCalls(), $calls));
    }
}
