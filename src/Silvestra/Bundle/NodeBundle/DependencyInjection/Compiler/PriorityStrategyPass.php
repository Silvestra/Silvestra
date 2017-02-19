<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/22/15 7:52 PM
 */
class PriorityStrategyPass implements CompilerPassInterface
{

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('silvestra_node.priority.registry.strategy')) {
            return;
        }

        $definition = $container->getDefinition('silvestra_node.priority.registry.strategy');
        $taggedServices = $container->findTaggedServiceIds('silvestra_node.priority.strategy');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('set', array(new Reference($id)));
        }
    }
}
