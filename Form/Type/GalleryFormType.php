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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/11/14 9:17 PM
 */
class GalleryFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'images',
            'collection',
            array(
                'type' => new ImageFormType(),
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'options' => array(
                    'mimeTypes' => $options['mimeTypes'],
                    'maxFileSize' => $options['uploaderConfig']['maxFileSize'],
                    'maxWidth' => $options['uploaderConfig']['maxWidth'],
                    'maxHeight' => $options['uploaderConfig']['maxHeight'],
                    'minWidth' => $options['uploaderConfig']['minWidth'],
                    'minHeight' => $options['uploaderConfig']['minHeight'],
                ),
            )
        );
    }


    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $options['uploaderConfig']['acceptFileTypes'] = implode('|', array_keys($options['mimeTypes']));

        $settings = array(
            'cropperEnabled' => $options['cropperEnabled'],
            'uploaderConfig' => $options['uploaderConfig'],
            'cropperConfig' => $options['cropperConfig'],
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
                'mimeTypes' => array(
                    'png' => 'image/png',
                    'jpe' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg' => 'image/jpeg',
                    'gif' => 'image/gif',
                ),
                'cropperEnabled' => true,
                'uploaderConfig' => array(
                    'maxFileSize' => 5000000,
                    'maxWidth' => 1024,
                    'maxHeight' => 768,
                    'minWidth' => 0,
                    'minHeight' => 0,
                ),
                'cropperConfig' => array(
                    'x1' => 0,
                    'y1' => 0,
                    'x2' => 1024,
                    'y2' => 768,
                ),
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_media_gallery';
    }
}
