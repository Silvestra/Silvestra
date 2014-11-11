<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('silvestra_seo');

        $rootNode
            ->children()
                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->end()

                ->scalarNode('seo_metadata_manager')->defaultValue('silvestra_seo.manager.seo_metadata.default')
                    ->cannotBeEmpty()->end()

                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')->isRequired()
                            ->children()
                                ->scalarNode('seo_metadata')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('page')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default')->defaultValue('silvestra_seo.page.default')->end()
                        ->scalarNode('encoding')->defaultValue('UTF-8')->end()
                    ->end()
                ->end()

                ->arrayNode('presentation')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default')->defaultValue('silvestra_seo.presentation.default')->end()
                    ->end()
                ->end()
            ->end();


        return $treeBuilder;
    }
}
