<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Image;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/11/14 9:17 PM
 */
class ImageFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'image',
            'file',
            array(
                'label' => false,
                'required' => false,
//                'constraints' => array(
//                    new Image(array(
//                        'minWidth' => $options['minWidth'],
//                        'maxWidth' => $options['maxWidth'],
//                        'minHeight' => $options['minHeight'],
//                        'maxHeight' => $options['maxHeight'],
//                        'maxSize' => '50M',
//                        'mimeTypes' => $options['mimeTypes'],
//                    ))
//                ),
            )
        );

        $builder->add(
            'cropper',
            'hidden',
            array(
                'label' => false,
                'required' => false,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $settings = array(
            'maxWidth' => $options['maxWidth'],
            'maxHeight' => $options['maxHeight']
        );

        $view->vars['settings'] = json_encode($settings);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'label' => false,
                'mimeTypes' => array(
                    'png' => 'image/png',
                    'jpe' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg' => 'image/jpeg',
                    'gif' => 'image/gif',
                ),
                'maxFileSize' => '5M',
                'maxWidth' => 1024,
                'maxHeight' => 768,
                'minWidth' => 0,
                'minHeight' => 0,
                'attr' => array('class' => 'image-file')
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_media_image';
    }
}
