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
use Silvestra\Component\Media\ImageConfig;
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
     * @var ImageConfig
     */
    private $imageConfig;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     * @param ImageConfig $imageConfig
     * @param ValidatorInterface $validator
     */
    public function __construct(Filesystem $filesystem, ImageConfig $imageConfig, ValidatorInterface $validator)
    {
        $this->filesystem = $filesystem;
        $this->imageConfig = $imageConfig;
        $this->validator = $validator;
    }

    public function process(UploadedFile $uploadedFile, array $config)
    {
        $data = array('errors' => array());

        $errors = $this->validator->validateValue($uploadedFile, $this->getConstraint($uploadedFile, $config));
        if (0 === $errors->count()) {
            $filename = $this->getFilename($uploadedFile);
//            $uploadedFile->move($this->getTmpDir(), $filename);
            $data['file'] = '/silvestra_media/tmp/' . $filename;
        } else {
            foreach ($errors as $error) {
                $data['errors'][] = $error;
            }
        }

        return $data;
    }

    /**
     * Get constraint.
     *
     * @param UploadedFile $uploadedFile
     * @param array $config
     *
     * @return File|Image
     */
    private function getConstraint(array $config)
    {
        $options = array(
//            'maxSize' => '5M',
            'mimeTypes' => array_intersect_key(
                array_merge($this->mimeTypes, $this->imageMimeTypes),
                array_flip(explode('|', $config['acceptFileTypes']))
            ),
        );

        $options['minWidth'] = $config['minWidth'];
        $options['maxWidth'] = $config['maxWidth'];
        $options['minHeight'] = $config['minHeight'];
        $options['maxHeight'] = $config['maxHeight'];

        return new Image($options);
    }

    /**
     * @return string
     */
    private function getTmpDir()
    {
        if (false === is_dir($this->filesystem->getTmpFolder())) {
            $this->filesystem->mkdir($this->filesystem->getTmpFolder());
        }

        return $this->filesystem->getTmpFolder();
    }

    /**
     * @param UploadedFile $uploadedFile
     *
     * @return string
     */
    private function getFilename(UploadedFile $uploadedFile)
    {
        $filename = $uploadedFile->getClientOriginalName();
        if ($this->hasFileTmp($filename)) {
            $filename = $this->generateUniqueFilename($filename);
        }

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

    /**
     * @param string $filename
     *
     * @return bool
     */
    private function hasFileTmp($filename)
    {
        return $this->filesystem->exists($this->filesystem->getTmpFolder() . DIRECTORY_SEPARATOR . $filename);
    }
}
