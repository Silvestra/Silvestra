<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Form\Type;

use Silvestra\Component\Media\ImageConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
     * @var ImageConfig
     */
    private $config;

    /**
     * Constructor.
     *
     * @param ImageConfig $config
     */
    public function __construct(ImageConfig $config)
    {
        $this->config = $config;
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
                'types' => $this->config->getAvailableMimeTypes(),
                'max_file_size' => $this->config->getMaxFileSize(),
                'max_height' => $this->config->getMaxHeight(),
                'max_width' => $this->config->getMaxWidth(),
                'min_height' => $this->config->getMinHeight(),
                'min_width' => $this->config->getMinWidth(),
                'resize_strategy' => $this->config->getDefaultResizeStrategy(),
                'cropper_enabled' => $this->config->isDefaultCropperEnabled(),
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
