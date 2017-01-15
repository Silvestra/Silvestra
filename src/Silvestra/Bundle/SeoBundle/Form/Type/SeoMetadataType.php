<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SeoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/15/14 12:15 AM
 */
class SeoMetadataType extends AbstractType
{
    /**
     * @var string
     */
    private $seoMetadataClass;

    /**
     * Constructor.
     *
     * @param string $seoMetadataClass
     */
    public function __construct($seoMetadataClass)
    {
        $this->seoMetadataClass = $seoMetadataClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            TextType::class,
            array(
                'label' => 'form.seo_metadata.page_title',
                'constraints' => array(new Assert\NotBlank()),
                'required' => false,
            )
        );

        $builder->add(
            'originalUrl',
            TextType::class,
            array(
                'label' => 'form.seo_metadata.original_url',
                'required' => false,
            )
        );

        $builder->add(
            'metaDescription',
            TextareaType::class,
            array(
                'label' => 'form.seo_metadata.meta_description',
                'required' => false,
            )
        );

        $builder->add(
            'metaKeywords',
            'silvestra_tag',
            array(
                'label' => 'form.seo_metadata.meta_keywords',
                'required' => false,
                'separator' => ','
            )
        );

        $builder->add(
            'metaRobots',
            TextareaType::class,
            array(
                'label' => 'form.seo_metadata.meta_robots',
                'required' => false,
            )
        );

        $builder->add(
            'extraHttp',
            'silvestra_key_value',
            array(
                'label' => 'form.seo_metadata.extra_http',
                'required' => false,
                'value_type' => 'text',
            )
        );

        $builder->add(
            'extraNames',
            'silvestra_key_value',
            array(
                'label' => 'form.seo_metadata.extra_names',
                'required' => false,
                'value_type' => 'text',
            )
        );

        $builder->add(
            'extraProperties',
            'silvestra_key_value',
            array(
                'label' => 'form.seo_metadata.extra_properties',
                'required' => false,
                'value_type' => 'text',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'translation_domain' => 'SilvestraSeoBundle',
                'data_class' => $this->seoMetadataClass,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'silvestra_seo_metadata';
    }
}
