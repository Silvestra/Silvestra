<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\CacheBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SilvestraCacheExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('http-cache.xml');

        $container->setParameter('silvestra_cache.http_cache_dir', $this->getHttpCacheDir($config, $container));
    }

    /**
     * Get http cache dir.
     *
     * @param array $config
     * @param ContainerBuilder $container
     *
     * @return string
     */
    private function getHttpCacheDir(array $config, ContainerBuilder $container)
    {
        return
            rtrim($container->getParameter('kernel.cache_dir'), '/\\')
                . DIRECTORY_SEPARATOR
                    . $config['http_cache_dir_name'];
    }
}
