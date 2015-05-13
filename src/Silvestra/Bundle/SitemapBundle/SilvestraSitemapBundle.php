<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SitemapBundle;

use Silvestra\Bundle\SitemapBundle\DependencyInjection\Compiler\ProfilePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SilvestraSitemapBundle extends Bundle
{

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ProfilePass());
    }
}
