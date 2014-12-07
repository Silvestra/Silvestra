<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Model\Manager;

abstract class ImageManager implements ImageManagerInterface
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
