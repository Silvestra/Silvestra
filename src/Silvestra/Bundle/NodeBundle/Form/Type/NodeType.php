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
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Silvestra\Bundle\NodeBundle\Validator\Constraints as AssertSitemap;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 5/19/14 10:50 PM
 */
class NodeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (false === $options['is_root']) {
            $builder->add(
                'type',
                'choice',
                array(
                    'choices' => $options['node_types'],
                    'empty_value' => 'form.select',
                    'empty_data' => null,
                    'constraints' => array(new Assert\NotBlank()),
                    'label' => 'form.node.type',
                )
            );

            $builder->add(
                'priority',
                'integer',
                array(
                    'required' => false,
                    'label' => 'form.node.priority',
                )
            );
        }

        $builder->add(
            'translations',
            'translations',
            array(
                'label' => false,
                'type' => new NodeTranslationType(),
                'options' => array(
                    'data_class' => $options['translation_class'],
                ),
            )
        );

        $builder->add('submit', 'submit', array('label' => 'form.button.save'));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('translation_class', 'node_types', 'is_root'));

        $resolver->setDefaults(
            array(
                'translation_domain' => 'TadckaSitemapBundle',
                'attr' => array('class' => 'tadcka_node'),
                'constraints' => function (Options $options) {
                    if (0 < count($options['node_types'])) {
                        return array(new AssertSitemap\NodeType());
                    }

                    return array();
                },
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tadcka_node';
    }
}
