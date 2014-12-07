<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Image\Cache;

use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Media;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/2/14 11:05 PM
 */
class ImageCache implements ImageCacheInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function contains($filename, $key)
    {
        return file_exists($this->getAbsolutePath($filename, $key));
    }

    /**
     * {@inheritdoc}
     */
    public function getAbsolutePath($filename, $key)
    {
        return $this->filesystem->getRootDir() . $this->getRelativePath($filename, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getRelativePath($filename, $key)
    {
        $parts = array(Media::NAME, Filesystem::CACHE_SUB_DIR, trim($key, DIRECTORY_SEPARATOR), $filename);

        return DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($filename, $key)
    {
        if ($this->contains($filename, $key)) {
            unlink($this->getAbsolutePath($filename, $key));
        }
    }
}
