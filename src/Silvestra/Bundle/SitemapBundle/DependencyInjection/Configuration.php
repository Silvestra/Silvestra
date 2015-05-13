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
                ->scalarNode('max_per_sitemap')->defaultValue(50000)->end()

                ->scalarNode('render')->defaultValue('silvestra_sitemap.render.xml')->cannotBeEmpty()->end()

                ->scalarNode('target')->defaultValue('%kernel.root_dir%/../web')->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}
