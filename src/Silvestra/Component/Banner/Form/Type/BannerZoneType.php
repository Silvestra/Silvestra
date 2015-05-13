<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/3/14 1:31 AM
 */
class BannerZoneType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * Constructor.
     *
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isSystem = $builder->getData() ? $builder->getData()->isSystem() : false;

        $builder->add(
            'name',
            'text',
            array(
                'label' => 'form.banner_zone.name',
                'required' => false,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3, 'max' => 255)))
            )
        );

        $builder->add(
            'code',
            'text',
            array(
                'label' => 'form.banner_zone.code',
                'required' => false,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('max' => 255)))
            )
        );

        $builder->add(
            'slug',
            'text',
            array(
                'label' => 'form.banner_zone.slug',
                'required' => false,
                'constraints' => array(new Assert\NotBlank()),
                'disabled' => $isSystem
            )
        );

        $builder->add(
            'width',
            'integer',
            array(
                'label' => 'form.banner_zone.width',
                'required' => false,
                'constraints' => array(new Assert\NotBlank()),
                'disabled' => $isSystem
            )
        );

        $builder->add(
            'height',
            'integer',
            array(
                'label' => 'form.banner_zone.height',
                'required' => false,
                'constraints' => array(new Assert\NotBlank()),
                'disabled' => $isSystem
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
                'data_class' => $this->class,
                'translation_domain' => 'SilvestraBanner'
            )
        );
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_banner_zone';
    }
}
