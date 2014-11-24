<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Handler;

use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Image\ImageGenerator;
use Silvestra\Component\Media\Model\ImageInterface;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\ValidatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/20/14 5:19 PM
 */
class UploaderHandler
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
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     * @param ImageManagerInterface $imageManager
     * @param ValidatorInterface $validator
     */
    public function __construct(
        Filesystem $filesystem,
        ImageManagerInterface $imageManager,
        ValidatorInterface $validator
    ) {
        $this->filesystem = $filesystem;
        $this->imageManager = $imageManager;
        $this->validator = $validator;
    }

    public function process(UploadedFile $uploadedImage, array $config, $isNew)
    {
        if ($errors = $this->validateUploadImage($uploadedImage, $config)) {
            return array('errors' => $errors);
        }

        $image = null;

        if (false === $isNew) {

        }

        if (null === $image) {
            $image = $this->createImage($uploadedImage);
        }

        return $data;
    }

    /**
     * Validate upload image.
     *
     * @param UploadedFile $uploadedImage
     * @param array $config
     *
     * @return array
     */
    private function validateUploadImage(UploadedFile $uploadedImage, array $config)
    {
        $errors = array();

        if ($errors = $this->validator->validateValue($uploadedImage, $this->getConstraint($config))) {
            foreach ($errors as $error) {
                $errors[] = $error->getMessage();
            }
        }

        return $errors;
    }

    /**
     * Get constraint.
     *
     * @param array $config
     *
     * @return File|Image
     */
    private function getConstraint(array $config)
    {
        $options = array(
//            'maxSize' => '5M',
            'mimeTypes' => $config['mime_types'],
        );

        $options['maxHeight'] = $config['max_height'];
        $options['maxWidth'] = $config['max_width'];
        $options['minHeight'] = $config['min_height'];
        $options['minWidth'] = $config['min_width'];


        return new Image($options);
    }

    private function updateImage(UploadedFile $uploadedImage, array $config)
    {
        $image = $this->imageManager->findByFilename($uploadedImage->getClientOriginalName());
        if (null !== $image) {
            $image->setSize($uploadedImage->getClientSize());
            $image->setMimeType($uploadedImage->getClientMimeType());
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
    private function createImage(UploadedFile $uploadedImage)
    {
        $image  = $this->imageManager->create();

        $image->setFilename($this->getUniqueFilename($uploadedImage));
        $image->setMimeType($uploadedImage->getClientMimeType());
        $image->setOriginalPath($this->filesystem->getActualFileDir($image->getFilename()));
        $image->setSize($uploadedImage->getClientSize());

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
