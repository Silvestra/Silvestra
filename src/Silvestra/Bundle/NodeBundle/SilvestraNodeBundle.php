<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Silvestra\Bundle\NodeBundle\DependencyInjection\Compiler\PriorityStrategyPass;
use Tadcka\Component\Tree\DependencyInjection\AddNodeTypeConfigPass;
use Tadcka\Component\Tree\DependencyInjection\AddTreeConfigPass;
use Tadcka\Component\Tree\DependencyInjection\RegisterNodeTypeConfigPass;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 5/30/14 12:08 AM
 */
class SilvestraNodeBundle extends Bundle
{
    const SITEMAP_TREE = 'silvestra_node';

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(
            new AddTreeConfigPass('silvestra_node.tree.registry', 'silvestra_node.tree.config')
        );
        $container->addCompilerPass(
            new AddNodeTypeConfigPass('silvestra_node.node_type.registry', 'silvestra_node.node_type.config')
        );
        $container->addCompilerPass(
            new RegisterNodeTypeConfigPass('silvestra_node.node_type.registry', 'silvestra_node.node_type')
        );

        $container->addCompilerPass(new PriorityStrategyPass());

        $this->addRegisterMappingsPass($container);
        $this->enabledTreeExtension($container);
    }

    /**
     * Add register mappings pass.
     *
     * @param ContainerBuilder $container
     */
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Tadcka\Component\Tree\Model',
        );

        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings));
        }
    }

    /**
     * Enabled tree extension.
     *
     * @param ContainerBuilder $container
     */
    private function enabledTreeExtension(ContainerBuilder $container)
    {
        $container->prependExtensionConfig(
            'stof_doctrine_extensions',
            array(
                'default_locale' => '%locale%',
                'orm' => array('default' => array('tree' => true)),
            )
        );
    }
}
