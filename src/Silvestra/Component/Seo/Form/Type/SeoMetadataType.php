<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
            'text',
            array(
                'label' => 'form.seo_metadata.page_title',
                'constraints' => array(new Assert\NotBlank()),
                'required' => false,
            )
        );

        $builder->add(
            'metaDescription',
            'textarea',
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
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
    public function getName()
    {
        return 'silvestra_seo_metadata';
    }
}
