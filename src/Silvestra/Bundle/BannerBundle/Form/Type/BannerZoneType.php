<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\BannerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
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
            TextType::class,
            array(
                'label' => 'form.banner_zone.name',
                'required' => false,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3, 'max' => 255)))
            )
        );

        $builder->add(
            'code',
            TextType::class,
            array(
                'label' => 'form.banner_zone.code',
                'required' => false,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('max' => 255)))
            )
        );

        $builder->add(
            'slug',
            TextType::class,
            array(
                'label' => 'form.banner_zone.slug',
                'required' => false,
                'constraints' => array(new Assert\NotBlank()),
                'disabled' => $isSystem
            )
        );

        $builder->add(
            'width',
            IntegerType::class,
            array(
                'label' => 'form.banner_zone.width',
                'required' => false,
                'constraints' => array(new Assert\NotBlank()),
                'disabled' => $isSystem
            )
        );

        $builder->add(
            'height',
            IntegerType::class,
            array(
                'label' => 'form.banner_zone.height',
                'required' => false,
                'constraints' => array(new Assert\NotBlank()),
                'disabled' => $isSystem
            )
        );

        $builder->add('submit', SubmitType::class, array('label' => 'form.button.save'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
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
    public function getBlockPrefix()
    {
        return 'silvestra_banner_zone';
    }
}
