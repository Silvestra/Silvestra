<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\Twig\Extension;

use Silvestra\Component\Media\Templating\ImageTemplatingHelperInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class ImageExtension extends \Twig_Extension
{
    /**
     * @var ImageTemplatingHelperInterface
     */
    private $imageHelper;

    /**
     * Constructor.
     *
     * @param ImageTemplatingHelperInterface $imageHelper
     */
    public function __construct(ImageTemplatingHelperInterface $imageHelper)
    {
        $this->imageHelper = $imageHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'silvestra_image_html_tag',
                array($this->imageHelper, 'renderImageHtmlTag'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFunction(
                'silvestra_resize_image',
                array($this->imageHelper, 'resizeImage')
            ),
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
