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

use Silvestra\Component\Media\Image\ImageCropper;
use Silvestra\Component\Media\Image\ImageUploader;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ValidatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/20/14 5:19 PM
 */
class ImageUploadHandler
{
    /**
     * @var ImageCropper
     */
    private $imageCropper;

    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Constructor.
     *
     * @param ImageCropper $imageCropper
     * @param ImageManagerInterface $imageManager
     * @param ImageUploader $imageUploader
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ImageCropper $imageCropper,
        ImageManagerInterface $imageManager,
        ImageUploader $imageUploader,
        ValidatorInterface $validator
    ) {
        $this->imageCropper = $imageCropper;
        $this->imageManager = $imageManager;
        $this->imageUploader = $imageUploader;
        $this->validator = $validator;
    }

    public function process(UploadedFile $uploadedImage, array $config, $isNew)
    {
        if ($errors = $this->validateUploadImage($uploadedImage, $config)) {
            return array('errors' => $errors);
        }

        $image = null;

        if (false === $isNew) {
            $this->imageUploader->updateImage($uploadedImage);
        }

        if (null === $image) {
            $image = $this->imageUploader->createImage($uploadedImage);

            $image->setTemporary(true);
            $this->imageManager->add($image);
        }

        if ($config['cropper_enabled']) {
            // TODO
            $image->setPath($image->getOriginalPath());
        } else {
            $image->setPath($image->getOriginalPath());
        }

        $this->imageManager->save();

        return array();
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

        foreach ($this->validator->validateValue($uploadedImage, $this->getConstraint($config)) as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }

    /**
     * Get constraint.
     *
     * @param array $config
     *
     * @return Assert\Image
     */
    private function getConstraint(array $config)
    {
        $options = array(
            'maxSize' => '5M',
            'mimeTypes' => $config['mime_types'],
        );

        $options['maxHeight'] = $config['max_height'];
        $options['maxWidth'] = $config['max_width'];
        $options['minHeight'] = $config['min_height'];
        $options['minWidth'] = $config['min_width'];


        return new Assert\Image($options);
    }
}
