<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image;

use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Model\ImageInterface;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/24/14 11:47 PM
 */
class ImageUploader
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ImageGenerator
     */
    private $imageGenerator;

    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     * @param ImageGenerator $imageGenerator
     * @param ImageManagerInterface $imageManager
     */
    public function __construct(
        Filesystem $filesystem,
        ImageGenerator $imageGenerator,
        ImageManagerInterface $imageManager
    ) {
        $this->filesystem = $filesystem;
        $this->imageGenerator = $imageGenerator;
        $this->imageManager = $imageManager;
    }

    /**
     * Update image.
     *
     * @param UploadedFile $uploadedImage
     *
     * @return ImageInterface
     */
    public function updateImage(UploadedFile $uploadedImage)
    {
        $image = $this->imageManager->findByFilename($uploadedImage->getClientOriginalName());

        if (null !== $image) {
            $image->setMimeType($uploadedImage->getClientMimeType());
            $image->setSize($uploadedImage->getClientSize());
            $image->setUpdatedAt(new \DateTime());

            $uploadedImage->move($this->filesystem->getActualFileDir($image->getFilename()), $image->getFilename());
        }

        return $image;
    }

    /**
     * Create image.
     *
     * @param UploadedFile $uploadedImage
     *
     * @return ImageInterface
     */
    public function createImage(UploadedFile $uploadedImage)
    {
        $image = $this->imageManager->create();
        $filename = $this->getUniqueFilename($uploadedImage);

        $image->setFilename($filename);
        $image->setMimeType($uploadedImage->getClientMimeType());
        $image->setOriginalPath($this->filesystem->getRelativeFilePath($filename));
        $image->setSize($uploadedImage->getClientSize());

        $uploadedImage->move($this->filesystem->getActualFileDir($filename), $image->getFilename());

        return $image;
    }

    /**
     * Get unique filename.
     *
     * @param UploadedFile $uploadedImage
     *
     * @return string
     */
    private function getUniqueFilename(UploadedFile $uploadedImage)
    {
        return $this->imageGenerator->generateUniqueFilename($uploadedImage->getClientOriginalName());
    }
}
