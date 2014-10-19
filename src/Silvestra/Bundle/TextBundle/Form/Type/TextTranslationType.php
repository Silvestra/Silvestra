<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\TextBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class TextTranslationType extends AbstractType
{
    /**
     * @var string
     */
    private $textTranslationClass;

    /**
     * Constructor.
     *
     * @param string $textTranslationClass
     */
    public function __construct($textTranslationClass)
    {
        $this->textTranslationClass = $textTranslationClass;
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
                'label' => 'form.text_translation.title',
                'required' => false,
                'constraints' => array(new NotBlank()),
            )
        );

        $builder->add(
            'content',
            'ckeditor',
            array(
                'label' => 'form.text_translation.content',
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
                'translation_domain' => 'SilvestraTextBundle',
                'data_class' => $this->textTranslationClass,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_text_translation';
    }
}
