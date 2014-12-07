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

use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Image\ImageResizerInterface;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Component\Templating\Helper\Helper as TemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/6/14 6:33 PM
 */
class ImageTemplatingHelper extends TemplatingHelper implements ImageTemplatingHelperInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

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
     * @param Filesystem $filesystem
     * @param ImageManagerInterface $imageManager
     * @param ImageResizerInterface $imageResizer
     * @param string $noImagePath
     */
    public function __construct(
        Filesystem $filesystem,
        ImageManagerInterface $imageManager,
        ImageResizerInterface $imageResizer,
        $noImagePath
    ) {
        $this->filesystem = $filesystem;
        $this->imageManager = $imageManager;
        $this->imageResizer = $imageResizer;
        $this->noImagePath = $noImagePath;
    }

    /**
     * {@inheritdoc}
     */
    public function renderImageHtmlTag($filename, array $size, $mode = null, array $attributes = array())
    {
        $path = $this->resizeImage($filename, $size, $mode);

        return sprintf('<img src="%s" %s />', $path, $this->normalizeAttributes($attributes));
    }

    /**
     * {@inheritdoc}
     */
    public function resizeImage($filename, array $size, $mode = null)
    {
        if (null === $mode) {
            $mode = ImageResizerInterface::THUMBNAIL_OUTBOUND;
        }

        $path = $this->getImagePath($filename);

        if (empty($size)) {
            return $path;
        }

        return $this->imageResizer->resize($path, $size[0], $size[1], $mode);
    }

    /**
     * Get image path.
     *
     * @param string $filename
     *
     * @return string
     */
    private function getImagePath($filename)
    {
        if (empty($filename)) {
            return $this->noImagePath;
        }

        if (file_exists($this->filesystem->getRootDir() . $filename)) {
            return $filename;
        }

        $image = $this->imageManager->findByFilename($filename);

        if (null !== $image) {
            return $image->getPath();
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
