<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media;

use Silvestra\Component\Media\Exception\InvalidArgumentException;
use Silvestra\Component\Media\Exception\IOException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.9.14 00.07
 */
class Filesystem
{
    /**
     * Cache sub directory.
     */
    const CACHE_SUB_DIR = 'cache';

    /**
     * Cropper sub directory.
     */
    const CROPPER_SUB_DIR = 'cropper';

    /**
     * Uploader sub directory.
     */
    const UPLOADER_SUB_DIR = 'uploader';

    /**
     * Root directory.
     *
     * @var string
     */
    private $rootDir;

    /**
     * Prefix directories size
     *
     * For instance, if the file is silvestra.png and the prefix size is
     * 5, the media file will be: s/i/l/v/e/silvestra.png
     *
     * @var int
     */
    protected $prefixSize = 5;

    /**
     * Directory mode
     *
     * Allows setting of the access mode for the directories created.
     *
     * @var int
     */
    protected $mode = 0755;

    /**
     * Constructor.
     *
     * @param string $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = rtrim($rootDir, '/\\');
    }

    /**
     * Get actual file dir.
     *
     * @param string $filename
     * @param string $subDir
     *
     * @return string
     */
    public function getActualFileDir($filename, $subDir = self::UPLOADER_SUB_DIR)
    {
        return $this->getPath(array($this->getMediaRootDir(), $subDir, $this->getFileDirPrefix($filename)));
    }

    /**
     * Get file dir prefix.
     *
     * @param string $filename
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getFileDirPrefix($filename)
    {
        if (empty($filename)) {
            throw new InvalidArgumentException('Invalid filename argument');
        }

        $path = array();
        $parts = explode('.', $filename);

        for ($i = 0; $i < min(strlen($parts[0]), $this->prefixSize); $i++) {
            $path[] = $filename[$i];
        }

        $path = $this->getPath($path);

        return $path;
    }

    /**
     * Get media root dir.
     *
     * @return string
     */
    public function getMediaRootDir()
    {
        return $this->getPath(array($this->rootDir, Media::NAME));
    }

    /**
     * Get root dir.
     *
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * Creates a directory.
     *
     * @param string $dir
     */
    public function mkdir($dir)
    {
        if (!is_dir($dir)) {
            @mkdir($dir, $this->mode, true);
        }
    }

    /**
     * Get absolute file path.
     *
     * @param string $filename
     * @param string $subDir
     *
     * @return string
     */
    public function getAbsoluteFilePath($filename, $subDir = self::UPLOADER_SUB_DIR)
    {
        return $this->rootDir . $this->getRelativeFilePath($filename, $subDir);
    }

    /**
     * Get relative file path.
     *
     * @param string $filename
     * @param string $subDir
     *
     * @return string
     */
    public function getRelativeFilePath($filename, $subDir = self::UPLOADER_SUB_DIR)
    {
        $pathParts = array(Media::NAME, $subDir, $this->getFileDirPrefix($filename), $filename);

        return  DIRECTORY_SEPARATOR . $this->getPath($pathParts);
    }

    /**
     * Get path.
     *
     * @param array $pathParts
     *
     * @return string
     */
    private function getPath(array $pathParts)
    {
        return implode(DIRECTORY_SEPARATOR, $pathParts);
    }
}
