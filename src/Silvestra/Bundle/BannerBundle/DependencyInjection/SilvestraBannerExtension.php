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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SilvestraBannerExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('form/banner.xml');
        $loader->load('form/banner-zone.xml');
        $loader->load('controllers.xml');
        $loader->load('services.xml');

        if (!in_array(strtolower($config['db_driver']), array('mongodb', 'orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }
        $loader->load('db_driver/' . sprintf('%s.xml', $config['db_driver']));

        $container->setParameter($this->getAlias() . '.model.banner.class', $config['class']['model']['banner']);
        $container->setParameter(
            $this->getAlias() . '.model.banner_zone.class',
            $config['class']['model']['banner_zone']
        );

        $container->setAlias($this->getAlias() . '.manager.banner', $config['banner_manager']);
        $container->setAlias($this->getAlias() . '.manager.banner_zone', $config['banner_zone_manager']);
    }
}
