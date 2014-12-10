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

use Silvestra\Component\Locale\Helper\LocaleHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/6/14 1:44 PM
 */
class BannerType extends AbstractType
{
    /**
     * @var string
     */
    private $bannerClass;

    /**
     * @var LocaleHelper
     */
    private $localeHelper;

    /**
     * Constructor.
     *
     * @param string $bannerClass
     * @param LocaleHelper $localeHelper
     */
    public function __construct($bannerClass, LocaleHelper $localeHelper)
    {
        $this->bannerClass = $bannerClass;
        $this->localeHelper = $localeHelper;
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
                'label' => 'form.banner.title',
                'required' => false,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3, 'max' => 255)))
            )
        );

        $builder->add(
            'description',
            'textarea',
            array(
                'label' => 'form.banner.description',
                'required' => false,
            )
        );

        $builder->add(
            'lang',
            'choice',
            array(
                'label' => 'form.banner.language',
                'choices' => $this->localeHelper->getDisplayLocales(),
            )
        );

        $builder->add(
            'uri',
            'text',
            array(
                'label' => 'form.banner.uri',
                'required' => false,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('max' => 511)), new Assert\Url())
            )
        );

        $builder->add(
            'position',
            'integer',
            array(
                'label' => 'form.banner.position',
                'required' => false,
                'constraints' => array(new Assert\NotBlank())
            )
        );

        $builder->add(
            'blank',
            'checkbox',
            array(
                'label' => 'form.banner.blank',
                'required' => false,
            )
        );

        $builder->add(
            'publish',
            'checkbox',
            array(
                'label' => 'form.banner.publish',
                'required' => false,
            )
        );

        $builder->add(
            'publishFrom',
            'datetime',
            array(
                'label' => 'form.banner.publish_from',
                'required' => false,
            )
        );

        $builder->add(
            'publishTo',
            'datetime',
            array(
                'label' => 'form.banner.publish_to',
                'required' => false,
            )
        );

        $builder->add(
            'image',
            'silvestra_media_image',
            array(
                'required' => false,
                'constraints' => array(new Assert\NotBlank())
            )
        );

        $builder->add(
            'script',
            'textarea',
            array(
                'label' => 'form.banner.script',
                'required' => false,
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
                'data_class' => $this->bannerClass,
                'translation_domain' => 'SilvestraBanner'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_banner';
    }
}
