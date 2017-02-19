<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Form\Type;

use Nercury\TranslationEditorBundle\Form\Type\TranslationsEditorType;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class NercuryTranslationsEditorType extends TranslationsEditorType
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultEditorLocales()
    {
        if ($this->container->getParameter('silvestra_node.multi_language.enabled')) {
            return $this->container->getParameter('silvestra_node.multi_language.locales');
        }

        return array($this->container->getParameter('locale'));
    }
}
