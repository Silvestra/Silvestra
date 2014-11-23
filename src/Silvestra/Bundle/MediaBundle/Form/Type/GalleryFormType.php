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
                    'types' => $options['types'],
                    'max_file_size' => $options['max_file_size'],
                    'max_height' => $options['max_height'],
                    'max_width' => $options['max_width'],
                    'min_height' => $options['min_height'],
                    'min_width' => $options['min_width'],
                    'resize_strategy' => $options['resize_strategy'],
                    'cropper_enabled' => $options['cropper_enabled'],
                    'cropper_coordinates' => $options['cropper_coordinates'],
                ),
            )
        );
    }


    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $settings = array(
            'types' => $options['types'],
            'max_file_size' => $options['max_file_size'],
            'max_height' => $options['max_height'],
            'max_width' => $options['max_width'],
            'min_height' => $options['min_height'],
            'min_width' => $options['min_width'],
            'resize_strategy' => $options['resize_strategy'],
            'cropper_enabled' => $options['cropper_enabled'],
            'cropper_coordinates' => $options['cropper_coordinates'],
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
                'types' => array('image/png', 'image/jpeg', 'image/jpeg', 'image/jpeg', 'image/gif'),
                'max_file_size' => 5000000,
                'max_height' => 800,
                'max_width' => 800,
                'min_height' => 100,
                'min_width' => 100,
                'resize_strategy' => 'max',
                'cropper_enabled' => true,
                'cropper_coordinates' => array(
                    'x1' => 0,
                    'y1' => 0,
                    'x2' => 800,
                    'y2' => 800,
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
