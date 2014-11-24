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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.9.14 00.07
 */
class Filesystem
{
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
    protected $dirMode = 0755;

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
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function getActualFileDir($filename)
    {
        return $this->getMediaRootDir() . DIRECTORY_SEPARATOR . $this->getFileDirPrefix($filename);
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

        $path = implode(DIRECTORY_SEPARATOR, $path);

        return $path;
    }

    /**
     * Get media root dir.
     *
     * @return string
     */
    public function getMediaRootDir()
    {
        return $this->rootDir . DIRECTORY_SEPARATOR . Media::NAME;
    }


    /**
     * Creates a directory.
     *
     * @param string $dir
     */
    public function mkdir($dir)
    {
        if (!is_dir($dir)) {
            @mkdir($dir, $this->dirMode, true);
        }
    }
}
