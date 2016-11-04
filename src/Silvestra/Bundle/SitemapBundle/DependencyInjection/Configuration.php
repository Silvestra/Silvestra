<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SitemapBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('silvestra_sitemap');

        $rootNode
            ->children()

                ->arrayNode('http_cache')->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('ttl')->defaultValue(86400)->cannotBeEmpty()->end()
                    ->end()
                ->end()

                ->integerNode('max_per_sitemap')->defaultValue(50000)->cannotBeEmpty()->end()

                ->scalarNode('render')->defaultValue('silvestra_sitemap.render.xml')->cannotBeEmpty()->end()
                ->scalarNode('sitemap_dir')->defaultValue('sitemap')->end()
                ->scalarNode('web_dir')->defaultValue('%kernel.root_dir%/../web')->cannotBeEmpty()->end()


            ->end();

        return $treeBuilder;
    }
}
