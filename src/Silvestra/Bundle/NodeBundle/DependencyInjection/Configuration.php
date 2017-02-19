<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Silvestra\Bundle\NodeBundle\Routing\RouteGenerator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 6/24/14 1:23 PM
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('silvestra_node');

        $rootNode
            ->children()
                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->end()

                ->scalarNode('tree_manager')->defaultValue('silvestra_node.manager.tree.default')
                    ->cannotBeEmpty()->end()

                ->scalarNode('node_manager')->defaultValue('silvestra_node.manager.node.default')
                    ->cannotBeEmpty()->end()

                ->scalarNode('node_translation_manager')
                    ->defaultValue('silvestra_node.manager.node_translation.default')->cannotBeEmpty()->end()

                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')->isRequired()
                            ->children()
                                ->scalarNode('tree')->isRequired()->end()
                                ->scalarNode('node')->isRequired()->end()
                                ->scalarNode('node_translation')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('node_type')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('controllers')
                            ->useAttributeAsKey('type')->prototype('scalar')->end()
                        ->end()
                        ->booleanNode('use_redirect_type')->defaultTrue()->end()
                    ->end()
                ->end()

                ->arrayNode('priority')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('strategy')->defaultNull()->end()
                    ->end()
                ->end()

                ->arrayNode('multi_language')->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->arrayNode('locales')
                            ->beforeNormalization()
                                ->ifString()
                                ->then(
                                    function ($value) {
                                        return preg_split('/\s*,\s*/', $value);
                                    }
                                )
                            ->end()
                            ->requiresAtLeastOneElement()->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('route')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('strategy')->defaultValue(RouteGenerator::STRATEGY_SIMPLE)
                            ->cannotBeEmpty()->end()
                        ->booleanNode('recursive_invisible')->defaultTrue()->cannotBeEmpty()->end()
                    ->end()
                ->end()

                ->arrayNode('link_attributes')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('available')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
