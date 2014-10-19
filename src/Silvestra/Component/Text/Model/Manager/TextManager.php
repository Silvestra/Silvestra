<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Text\Model\Manager;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
abstract class TextManager implements TextManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $class = $this->getClass();
        $text = new $class;

        return $text;
    }
}
