<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\PaginatorBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('silvestra_paginator');

        $rootNode
            ->children()
                // Default template
                ->scalarNode('default_template')
                    ->defaultValue('SilvestraPaginatorBundle:Pagination:bootstrap.html.twig')
                    ->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}
