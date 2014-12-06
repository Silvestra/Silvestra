<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\DependencyInjection;

use Silvestra\Component\Media\Media;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('silvestra_media');

        $rootNode
            ->children()
                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->end()

                ->scalarNode('image_manager')->defaultValue('silvestra_media.manager.image.default')
                    ->cannotBeEmpty()->end()

                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')->isRequired()
                            ->children()
                                ->scalarNode('image')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('filesystem')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('root_dir')->defaultValue('')->end()
                    ->end()
                ->end()

                ->arrayNode('image')->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('available_mime_types')
                            ->defaultValue(Media::getImageMimeTypes())
                        ->end()
                        ->booleanNode('default_cropper_enabled')->defaultTrue()->end()
                        ->scalarNode('default_resize_strategy')->defaultValue('max')->end()
                        ->integerNode('max_file_size')->defaultValue(5)->end() // MB
                        ->integerNode('max_height')->defaultValue(768)->end()
                        ->integerNode('max_width')->defaultValue(1024)->end()
                        ->integerNode('min_height')->defaultValue(0)->end()
                        ->integerNode('min_width')->defaultValue(0)->end()
                        ->scalarNode('no_image')->defaultValue('/bundles/silvestramedia/image/noimage.png')->end()
                    ->end()
                ->end()

                ->arrayNode('token')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('key')->defaultValue(Media::NAME)->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
