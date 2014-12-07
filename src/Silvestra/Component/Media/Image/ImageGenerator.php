<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image;

use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/24/14 9:25 PM
 */
class ImageGenerator
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
     * Generate unique filename.
     *
     * @param string $originalFilename
     *
     * @return string
     */
    public function generateUniqueFilename($originalFilename)
    {
        $index = 0;
        $filename = pathinfo($originalFilename, PATHINFO_FILENAME);
        $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);

        while ($this->imageManager->findByFilename($originalFilename)) {
            $index++;
            $originalFilename = $filename . '-' . $index . '.' . $extension;
        }

        return $originalFilename;
    }
}
