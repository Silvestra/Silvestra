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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class TextType extends AbstractType
{
    /**
     * @var string
     */
    private $textClass;

    /**
     * Constructor.
     *
     * @param string $textClass
     */
    public function __construct($textClass)
    {
        $this->textClass = $textClass;
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
                'type' => 'silvestra_text_translation',
                'label' => false,
            )
        );

        $builder->add(
            'submit',
            'submit',
            array(
                'label' => 'form.button.submit'
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
                'data_class' => $this->textClass,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_text';
    }
}
