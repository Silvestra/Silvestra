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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  14.10.25 22.21
 */
class NodeRouteType extends AbstractType
{
    /**
     * @var string
     */
    private $nodeClass;

    /**
     * Constructor.
     *
     * @param string $nodeClass
     */
    public function __construct($nodeClass)
    {
        $this->nodeClass = $nodeClass;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'translations',
            'translations',
            array(
                'type' => 'silvestra_node_node_i18n_route',
                'label' => false,
                'options' => array(
                    'allowed_link_attributes' => $options['allowed_link_attributes'],
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
        $resolver->setDefaults(
            array(
                'data_class' => $this->nodeClass,
                'translation_domain' => 'TadckaSitemapBundle',
                'allowed_link_attributes' => array(),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_node_node_route';
    }
}
