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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SilvestraMediaExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('controllers.xml');
        $loader->load('form/gallery.xml');
        $loader->load('form/image.xml');
        $loader->load('image/config-validator.xml');
        $loader->load('image/services.xml');
        $loader->load('services.xml');
        $loader->load('templating.xml');
        $loader->load('token.xml');

        if (!in_array(strtolower($config['db_driver']), array('mongodb', 'orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }
        $loader->load('db_driver/' . sprintf('%s.xml', $config['db_driver']));

        $container->setAlias($this->getAlias() . '.manager.image', $config['image_manager']);
        $container->setAlias($this->getAlias() . '.image.cropper', $config['image']['cropper']);
        $container->setAlias($this->getAlias() . '.image.resizer', $config['image']['resizer']);

        $container->setParameter($this->getAlias() . '.model.image.class', $config['class']['model']['image']);
        $container->setParameter($this->getAlias() . '.token.key', $config['token']['key']);
        $container->setParameter($this->getAlias() . '.no_image', $config['image']['no_image']);

        if ($rootDir = $config['filesystem']['root_dir']) {
            $this->setFilesystemRootDir($rootDir, $container);
        }

        $this->setImageConfigs($config['image'], $container);
    }

    /**
     * Set filesystem root dir.
     *
     * @param string $rootDir
     * @param ContainerBuilder $container
     */
    private function setFilesystemRootDir($rootDir, ContainerBuilder $container)
    {
        $definition = $container->getDefinition($this->getAlias() . '.filesystem');

        $definition->replaceArgument(0, $rootDir);
    }

    /**
     * Set image configs.
     *
     * @param array $configs
     * @param ContainerBuilder $container
     */
    private function setImageConfigs(array $configs, ContainerBuilder $container)
    {
        $definition = $container->getDefinition('silvestra_media.image.default_config');

        $definition->addArgument($configs['available_mime_types']);
        $definition->addArgument($configs['default_cropper_enabled']);
        $definition->addArgument($configs['default_resize_strategy']);
        $definition->addArgument($configs['max_file_size']);
        $definition->addArgument($configs['max_height']);
        $definition->addArgument($configs['max_width']);
        $definition->addArgument($configs['min_height']);
        $definition->addArgument($configs['min_width']);
    }
}
