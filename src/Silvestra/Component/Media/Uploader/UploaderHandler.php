<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Uploader;

use Silvestra\Component\Media\Filesystem;
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
     * @var ValidatorInterface
     */
    private $validator;

    private $imageMimeTypes = array(
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
    );

    private $mimeTypes = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',
        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     * @param ValidatorInterface $validator
     */
    public function __construct(Filesystem $filesystem, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->filesystem = $filesystem;
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
    private function getConstraint(UploadedFile $uploadedFile, array $config)
    {
        $options = array(
//            'maxSize' => '5M',
            'mimeTypes' => array_intersect_key(
                array_merge($this->mimeTypes, $this->imageMimeTypes),
                array_flip(explode('|', $config['acceptFileTypes']))
            ),
        );

        if ($this->isImageFile($uploadedFile)) {
            $options['minWidth'] = $config['minWidth'];
            $options['maxWidth'] = $config['maxWidth'];
            $options['minHeight'] = $config['minHeight'];
            $options['maxHeight'] = $config['maxHeight'];

            return new Image($options);
        }

        return new File($options);
    }

    /**
     * Check if is image file.
     *
     * @param UploadedFile $uploadedFile
     *
     * @return bool
     */
    private function isImageFile(UploadedFile $uploadedFile)
    {
        return in_array($uploadedFile->getClientMimeType(), $this->imageMimeTypes);
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
