<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\Twig\Extension;

use Silvestra\Component\Media\Templating\ImageHelperInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/6/14 7:29 PM
 */
class ImageExtension extends \Twig_Extension
{
    /**
     * @var ImageHelperInterface
     */
    private $imageHelper;

    /**
     * Constructor.
     *
     * @param ImageHelperInterface $imageHelper
     */
    public function __construct(ImageHelperInterface $imageHelper)
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
