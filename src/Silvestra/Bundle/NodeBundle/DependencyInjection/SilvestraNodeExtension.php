<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Silvestra\Bundle\NodeBundle\Routing\RedirectRoute;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 6/24/14 1:23 PM
 */
class SilvestraNodeExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('controllers.xml');
        $loader->load('factories.xml');
        $loader->load('form/node.xml');
        $loader->load('form/node-redirect-route.xml');
        $loader->load('form/node-route.xml');
        $loader->load('form/node-seo.xml');
        $loader->load('frontend.xml');
        $loader->load('node.xml');
        $loader->load('priority-strategies.xml');
        $loader->load('routing.xml');
        $loader->load('services.xml');
        $loader->load('tree.xml');
        $loader->load('validators.xml');

        if (!in_array(strtolower($config['db_driver']), array('mongodb', 'orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }
        $loader->load('db_driver/' . sprintf('%s.xml', $config['db_driver']));

        if ($config['node_type']['use_redirect_type']) {
            $loader->load('node_type/redirect.xml');
        }

        $container->setParameter($this->getAlias() . '.model.tree.class', $config['class']['model']['tree']);
        $container->setParameter($this->getAlias() . '.model.node.class', $config['class']['model']['node']);
        $container->setParameter(
            $this->getAlias() . '.model.node_translation.class',
            $config['class']['model']['node_translation']
        );

        $container->setAlias($this->getAlias() . '.manager.tree', $config['tree_manager']);
        $container->setAlias($this->getAlias() . '.manager.node', $config['node_manager']);
        $container->setAlias($this->getAlias() . '.manager.node_translation', $config['node_translation_manager']);

        $controllers = array(RedirectRoute::NODE_TYPE => RedirectRoute::CONTROLLER);
        $controllers = array_merge($config['node_type']['controllers'], $controllers);

        $container->setParameter($this->getAlias() . '.node_type.controllers', $controllers);
        $container->setParameter($this->getAlias() . '.multi_language.enabled', $config['multi_language']['enabled']);
        $container->setParameter($this->getAlias() . '.multi_language.locales', $config['multi_language']['locales']);
        $container->setParameter($this->getAlias() . '.route.strategy', $config['route']['strategy']);
        $container->setParameter($this->getAlias() . '.route.recursive_invisible', $config['route']['recursive_invisible']);
        $container->setParameter($this->getAlias() . '.priority.strategy', $config['priority']['strategy']);
        $container->setParameter($this->getAlias() . '.link_attributes.available', $config['link_attributes']['available']);
    }
}
