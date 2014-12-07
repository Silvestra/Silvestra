<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\LocaleBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('silvestra_locale');

        $rootNode
            ->children()

                ->arrayNode('allowed_locales')->isRequired()
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

            ->end();

        return $treeBuilder;
    }
}
