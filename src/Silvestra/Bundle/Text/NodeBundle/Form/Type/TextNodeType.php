<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\Text\NodeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/26/14 9:30 PM
 */
class TextNodeType extends AbstractType
{
    /**
     * @var string
     */
    private $textNodeClass;

    /**
     * Constructor.
     *
     * @param string $textNodeClass
     */
    public function __construct($textNodeClass)
    {
        $this->textNodeClass = $textNodeClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', 'silvestra_text', array('label' => false));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('data_class' => $this->textNodeClass));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_text_node';
    }
}
