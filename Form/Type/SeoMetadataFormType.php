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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/15/14 12:15 AM
 */
class SeoMetadataFormType extends AbstractType
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
                'label' => 'form.seo_metadata.title',
                'constraints' => array(new NotBlank()),
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
            'textarea',
            array(
                'label' => 'form.seo_metadata.meta_keywords',
                'required' => false,
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
