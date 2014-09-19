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
            )
        );
    }


    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $options['uploaderConfig']['acceptFileTypes'] = implode('|', $options['uploaderConfig']['acceptFileTypes']);

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
                'cropperEnabled' => true,
                'uploaderConfig' => array(
                    'acceptFileTypes' => array('gif', 'jpg', 'jpeg', 'png'),
                    'maxFileSize' => 5000000,
                    'maxWidth' => 1024,
                    'maxHeight' => 768,
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
