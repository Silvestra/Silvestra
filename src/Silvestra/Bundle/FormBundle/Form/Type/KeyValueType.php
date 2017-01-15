<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\FormBundle\Form\Type;

use Silvestra\Bundle\FormBundle\Form\DataTransformer\KeyValueTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        $preSetDataListener = function (FormEvent $event) {
            if (null === $event->getData()) {
                return null;
            }

            $data = array();
            foreach ($event->getData() as $key => $value) {
                $data[] = array('key' => $key, 'value' => $value);
            }
            
            $event->setData($data);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, $preSetDataListener, 1);
        $builder->addModelTransformer(new KeyValueTransformer($options['use_key_value_array']));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'type' => KeyValueRowType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'allowed_keys' => null,
                'label' => false,
                'value_options' => array(),
                'use_key_value_array' => false,
                'options' => function (Options $options) {
                    return array(
                        'value_type' => $options['value_type'],
                        'value_options' => $options['value_options'],
                        'allowed_keys' => $options['allowed_keys'],
                        'label' => false,
                    );
                }
            )
        );

        $resolver->setAllowedTypes(array('allowed_keys' => array('null', 'array')));
        $resolver->setRequired(array('value_type'));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return CollectionType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'silvestra_key_value';
    }
}
