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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/2/14 11:16 PM
 */
interface ImageCacheInterface
{
    /**
     * Checks if the cache has image file.
     *
     * @param string $filename
     * @param string $key
     *
     * @return bool
     */
    public function contains($filename, $key);

    /**
     * Get image file absolute path.
     *
     * @param string $filename
     * @param string $key
     *
     * @return mixed
     */
    public function getAbsolutePath($filename, $key);

    /**
     * Get image file relative path.
     *
     * @param string $filename
     * @param string $key
     *
     * @return mixed
     */
    public function getRelativePath($filename, $key);

    /**
     * Drop image file.
     *
     * @param string $filename
     * @param string $key
     *
     * @return bool
     */
    public function remove($filename, $key);
}
