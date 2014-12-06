<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Templating;

use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Component\Templating\Helper\Helper as TemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/6/14 6:33 PM
 */
class ImageHelper extends TemplatingHelper
{
    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * Constructor.
     *
     * @param ImageManagerInterface $imageManager
     */
    public function __construct(ImageManagerInterface $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * {@inheritdoc}
     */
    public function renderImageHtmlTag($filename, array $size, array $attributes = array())
    {
        $path = $this->getImagePath($filename);

        if ((null === $filename) || (false === file_exists($path))) {

        }

        return sprintf('<img src="%s" />', $path);
    }

    /**
     * Get image path.
     *
     * @param string $filename
     *
     * @return null|string
     */
    private function getImagePath($filename)
    {
        if (empty($filename)) {
            return null;
        }

        if (file_exists($filename)) {
            return $filename;
        }

        $image = $this->imageManager->findByFilename($filename);

        if (null !== $image) {
            return $image->getPath();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_media_image';
    }
}
