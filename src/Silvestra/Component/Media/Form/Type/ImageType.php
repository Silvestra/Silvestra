<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Form\Type;

use Silvestra\Component\Media\Image\ImageDefaultConfig;
use Silvestra\Component\Media\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 3:57 PM
 */
class ImageType extends AbstractType
{
    /**
     * @var ImageDefaultConfig
     */
    private $defaultConfig;

    /**
     * @var string
     */
    private $imageClass;

    /**
     * Constructor.
     *
     * @param string $imageClass
     * @param ImageDefaultConfig $defaultConfig
     */
    public function __construct($imageClass, ImageDefaultConfig $defaultConfig)
    {
        $this->imageClass = $imageClass;
        $this->defaultConfig = $defaultConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cropperCoordinates', 'hidden');

        $builder->add('originalPath', 'hidden');
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $settings = array(
            'mime_types' => $options['mime_types'],
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
                'data_class' => $this->imageClass,
                'label' => false,

                'mime_types' => $this->defaultConfig->getAvailableMimeTypes(),
                'max_file_size' => $this->defaultConfig->getMaxFileSize(),
                'max_height' => $this->defaultConfig->getMaxHeight(),
                'max_width' => $this->defaultConfig->getMaxWidth(),
                'min_height' => $this->defaultConfig->getMinHeight(),
                'min_width' => $this->defaultConfig->getMinWidth(),
                'resize_strategy' => $this->defaultConfig->getDefaultResizeStrategy(),
                'cropper_enabled' => $this->defaultConfig->isDefaultCropperEnabled(),
                'cropper_coordinates' => function (Options $options) {
                    return array(
                        'x1' => 0,
                        'y1' => 0,
                        'x2' => $options['max_width'],
                        'y2' => $options['max_height'],
                    );
                }
            )
        );

        $defaultConfig = $this->defaultConfig;

        $resolver->setAllowedValues(
            array(
                'mime_types' => function ($mimeTypes) use ($defaultConfig) {
                    foreach ($mimeTypes as $type) {
                        if (!in_array($type, $defaultConfig->getAvailableMimeTypes())) {
                            return false;
                        }
                    }

                    return true;
                },
                'max_file_size' => function ($maxFileSize) use ($defaultConfig) {
                    return ($defaultConfig->getMaxFileSize() >= $maxFileSize);
                },
                'max_height' => function ($maxHeight) use ($defaultConfig) {
                    return ($defaultConfig->getMaxHeight() >= $maxHeight);
                },
                'max_width' => function ($maxWidth) use ($defaultConfig) {
                    return ($defaultConfig->getMaxWidth() >= $maxWidth);
                },
                'min_height' => function ($minHeight) use ($defaultConfig) {
                    return ($defaultConfig->getMinHeight() <= $minHeight);
                },
                'min_width' => function ($minWidth) use ($defaultConfig) {
                    return ($defaultConfig->getMinWidth() <= $minWidth);
                },
                'resize_strategy' => function ($resizeStrategy) {
                    return in_array($resizeStrategy, Media::getResizeStrategies());
                },
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
