<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/8/14 12:24 AM
 */
class KeyValueRowType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (null === $options['allowed_keys']) {
            $builder->add(
                'key',
                'text',
                array(
                    'label' => 'key_value_row.key',
                )
            );
        } else {
            $builder->add(
                'key',
                'choice',
                array(
                    'choice_list' => new SimpleChoiceList($options['allowed_keys']),
                    'label' => 'key_value_row.key',
                )
            );
        }

        $builder->add(
            'value',
            $options['value_type'],
            array_merge($options['value_options'], array('label' => 'key_value_row.value'))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'value_options' => array(),
                'allowed_keys' => null,
                'translation_domain' => 'SilvestraForm',
            )
        );

        $resolver->setAllowedTypes(array('allowed_keys' => array('null', 'array')));
        $resolver->setRequired(array('value_type'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_key_value_row';
    }
}
