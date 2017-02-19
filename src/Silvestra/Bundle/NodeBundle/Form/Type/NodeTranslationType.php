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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 5/19/14 10:50 PM
 */
class NodeTranslationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            'text',
            array(
                'label' => 'form.node_translation.title',
                'constraints' => array(new NotBlank()),
                'required' => false,
            )
        );

        $builder->add(
            'description',
            'ckeditor',
            array(
                'label' => 'form.node_translation.description',
                'required' => false
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'label' => false,
                'translation_domain' => 'TadckaSitemapBundle',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tadcka_node_translation';
    }
}
