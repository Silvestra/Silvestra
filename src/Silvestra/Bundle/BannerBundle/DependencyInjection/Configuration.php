<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\BannerBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('silvestra_banner');

        $rootNode
            ->children()

                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->end()

                ->scalarNode('banner_manager')->defaultValue('silvestra_banner.manager.banner.default')
                    ->cannotBeEmpty()->end()
                ->scalarNode('banner_zone_manager')->defaultValue('silvestra_banner.manager.banner_zone.default')
                    ->cannotBeEmpty()->end()

                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')->isRequired()
                            ->children()
                                ->scalarNode('banner')->isRequired()->end()
                                ->scalarNode('banner_zone')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end();


        return $treeBuilder;
    }
}
