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

use Silvestra\Component\Locale\Helper\LocaleHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
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
            TextType::class,
            array(
                'label' => 'form.banner.title',
                'required' => false,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 3, 'max' => 255)))
            )
        );

        $builder->add(
            'description',
            TextareaType::class,
            array(
                'label' => 'form.banner.description',
                'required' => false,
            )
        );

        $builder->add(
            'lang',
            ChoiceType::class,
            array(
                'label' => 'form.banner.language',
                'choices' => $this->localeHelper->getDisplayLocales(),
            )
        );

        $builder->add(
            'uri',
            TextType::class,
            array(
                'label' => 'form.banner.uri',
                'required' => false,
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('max' => 511)), new Assert\Url())
            )
        );

        $builder->add(
            'position',
            IntegerType::class,
            array(
                'label' => 'form.banner.position',
                'required' => false,
                'constraints' => array(new Assert\NotBlank())
            )
        );

        $builder->add(
            'blank',
            CheckboxType::class,
            array(
                'label' => 'form.banner.blank',
                'required' => false,
            )
        );

        $builder->add(
            'publish',
            CheckboxType::class,
            array(
                'label' => 'form.banner.publish',
                'required' => false,
            )
        );

        $builder->add(
            'publishFrom',
            DateType::class,
            array(
                'label' => 'form.banner.publish_from',
                'required' => false,
            )
        );

        $builder->add(
            'publishTo',
            DateType::class,
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
            )
        );

        $builder->add(
            'script',
            TextareaType::class,
            array(
                'label' => 'form.banner.script',
                'required' => false,
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
                'data_class' => $this->bannerClass,
                'translation_domain' => 'SilvestraBanner'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'silvestra_banner';
    }
}
