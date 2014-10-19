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

use Silvestra\Component\Form\DataTransformer\KeyValueTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/7/14 11:53 PM
 */
class KeyValueType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $listener = function (FormEvent $event) {
            $inputData = $event->getData();

            if (null === $inputData) {
                return null;
            }

            $outputData = array();
            foreach ($inputData as $key => $value) {
                $outputData[] = array('key' => $key, 'value' => $value);
            }

            $event->setData($outputData);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $listener);
        $builder->addModelTransformer(new KeyValueTransformer($options['use_key_value_array']));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array('value_type'));
        $resolver->setAllowedTypes(array('allowed_keys' => array('null', 'array')));

        $resolver->setDefaults(
            array(
                'type' => 'silvestra_key_value_row',
                'allow_add' => true,
                'allow_delete' => true,
                'value_options' => array(),
                'allowed_keys' => null,
                'use_key_value_array' => false,
                'options' => function (Options $options) {
                    return array(
                        'value_type' => $options['value_type'],
                        'value_options' => $options['value_options'],
                        'allowed_keys' => $options['allowed_keys']
                    );
                }
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_key_value';
    }
}
