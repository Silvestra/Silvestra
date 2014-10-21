<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Cache\Http;

use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.10.21 13.39
 */
class HttpCacheManager
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $httpCacheDir;

    /**
     * Constructor.
     *
     * @param Filesystem $filesystem
     * @param string $httpCacheDir
     */
    public function __construct(Filesystem $filesystem, $httpCacheDir)
    {
        $this->filesystem = $filesystem;
        $this->httpCacheDir = $httpCacheDir;
    }

    /**
     * Invalidate all http cache.
     */
    public function invalidateAll()
    {
        if (true === $this->filesystem->exists($this->httpCacheDir)) {
            $this->filesystem->remove($this->httpCacheDir);
        }
    }
}
