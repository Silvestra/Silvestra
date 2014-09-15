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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.9.14 00.07
 */
class Filesystem
{
    /**
     * @var string
     */
    private $uploaderFolder;

    /**
     * Constructor.
     *
     * @param string $uploaderFolder
     */
    public function __construct($uploaderFolder)
    {
        $this->uploaderFolder = $uploaderFolder;
    }

    /**
     * Get uploader folder.
     *
     * @return string
     */
    public function getUploaderFolder()
    {
        return rtrim($this->uploaderFolder, '/\\');
    }

    /**
     * Get temporary folder.
     *
     * @return string
     */
    public function getTmpFolder()
    {
        return $this->getUploaderFolder() . DIRECTORY_SEPARATOR  . 'tadcka_media_tmp';
    }
}
