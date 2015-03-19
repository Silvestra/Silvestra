<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Templating;

use Silvestra\Component\Media\Image\Resizer\ImageResizerInterface;
use Symfony\Component\Templating\Helper\Helper as TemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/6/14 6:33 PM
 */
class ImageTemplatingHelper extends TemplatingHelper implements ImageTemplatingHelperInterface
{

    /**
     * @var ImageResizerInterface
     */
    private $imageResizer;

    /**
     * @var string
     */
    private $noImagePath;

    /**
     * Constructor.
     *
     * @param ImageResizerInterface $imageResizer
     * @param string $noImagePath
     */
    public function __construct(ImageResizerInterface $imageResizer, $noImagePath)
    {
        $this->imageResizer = $imageResizer;
        $this->noImagePath = $noImagePath;
    }

    /**
     * {@inheritdoc}
     */
    public function renderImageHtmlTag($path, array $size, $mode = null, array $attributes = array())
    {
        $path = $this->resizeImage($path, $size, $mode);

        return sprintf('<img src="%s" %s />', $path, $this->normalizeAttributes($attributes));
    }

    /**
     * {@inheritdoc}
     */
    public function resizeImage($path, array $size, $mode = null)
    {
        if (null === $mode) {
            $mode = ImageResizerInterface::INSET;
        }

        $path = $this->getImagePath($path);

        if (empty($size)) {
            return $path;
        }

        return $this->imageResizer->resize($path, $size, $mode);
    }

    /**
     * Get image path.
     *
     * @param string $path
     *
     * @return string
     */
    private function getImagePath($path)
    {
        if ($path && file_exists($path)) {
            return $path;
        }

        return $this->noImagePath;
    }

    /**
     * {@inheritdoc}
     */
    private function normalizeAttributes(array $attributes)
    {
        $string = '';

        foreach ($attributes as $name => $value) {
            $string .= sprintf('%s="%s" ', $name, $value);
        }

        return rtrim($string);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_media_image';
    }
}
