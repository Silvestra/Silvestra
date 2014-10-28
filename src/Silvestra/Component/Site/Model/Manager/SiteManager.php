<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SiteBundle\Model\Manager;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
abstract class SiteManager implements SiteManagerInterface
{

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $className = $this->getClass();
        $value = new $className;

        return $value;
    }
}
