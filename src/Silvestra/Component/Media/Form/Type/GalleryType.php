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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 3:57 PM
 */
class GalleryType extends AbstractType
{
    /**
     * @var ImageDefaultConfig
     */
    private $defaultConfig;

    /**
     * Constructor.
     *
     * @param ImageDefaultConfig $defaultConfig
     */
    public function __construct(ImageDefaultConfig $defaultConfig)
    {
        $this->defaultConfig = $defaultConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'type' => 'silvestra_media_image',
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,

                'limit' => null,
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
                },

                'options' => function (Options $options) {
                    array(
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
                },
            )
        );


    }


    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_media_gallery';
    }
}
