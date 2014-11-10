<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Form\Type;

use Silvestra\Component\Form\DataTransformer\TagTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/9/14 9:33 PM
 */
class TagType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'tags',
            'collection',
            array(
                'type' => 'hidden',
                'allow_add' => true,
                'allow_delete' => true,
            )
        );

        $builder->addModelTransformer(new TagTransformer($options['separator']));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['silvestra_tag_data'] = $form->getData();

        $settings = sprintf("data-edit-on-delete=\"%s\" ", $options['edit-on-delete']);
        $settings .= sprintf("data-no-duplicate=\"%s\" ", $options['no-duplicate']);
        $settings .= sprintf("data-no-enter=\"%s\" ", $options['no-enter']);
        $settings .= sprintf("data-no-spacebar=\"%s\" ", $options['no-spacebar']);
        $settings .= sprintf("data-pre-tags-separator=\"%s\"", $options['separator']);

        $view->vars['silvestra_tag_settings'] = $settings;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'edit-on-delete' => true,
                'no-duplicate' => true,
                'no-enter' => true,
                'no-spacebar' => true,
                'separator' => ', ',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_tag';
    }
}
