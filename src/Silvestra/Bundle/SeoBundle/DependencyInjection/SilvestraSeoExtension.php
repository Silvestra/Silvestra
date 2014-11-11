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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SilvestraSeoExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('form/seo-metadata.xml');
        $loader->load('services.xml');

        if (!in_array(strtolower($config['db_driver']), array('mongodb', 'orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }
        $loader->load('db_driver/' . sprintf('%s.xml', $config['db_driver']));

        $container->setParameter(
            $this->getAlias() . '.model.seo_metadata.class',
            $config['class']['model']['seo_metadata']
        );
        $container->setParameter($this->getAlias() . '.page.encoding', $config['page']['encoding']);

        $container->setAlias($this->getAlias() . '.manager.seo_metadata', $config['seo_metadata_manager']);
        $container->setAlias($this->getAlias() . '.page', $config['page']['default']);
        $container->setAlias($this->getAlias() . '.page.presentation', $config['page']['presentation']);
    }
}
