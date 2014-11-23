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

    public function process(UploadedFile $uploadedFile, array $config)
    {
        $data = array();

        if ($errors = $this->validator->validateValue($uploadedFile, $this->getConstraint($config))) {
            foreach ($errors as $error) {
                $data['errors'][] = $error->getMessage();
            }

            return $data;
        }

        return $data;
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

    /**
     * @param UploadedFile $uploadedFile
     *
     * @return string
     */
    private function getFilename(UploadedFile $uploadedFile)
    {
        $filename = $uploadedFile->getClientOriginalName();
//        if ($this->hasFileTmp($filename)) {
//            $filename = $this->generateUniqueFilename($filename);
//        }

        return $filename;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    private function generateUniqueFilename($filename)
    {
        $key = 0;
        $originalFilename = pathinfo($filename, PATHINFO_FILENAME);
        $originalExtension = pathinfo($filename, PATHINFO_EXTENSION);

        while ($this->hasFileTmp($filename)) {
            $key++;
            $filename = $originalFilename . '-' . $key . '.' . $originalExtension;
        }

        return $filename;

    }
}
