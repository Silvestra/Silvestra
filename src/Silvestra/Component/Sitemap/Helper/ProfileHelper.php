<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Helper;

use Symfony\Component\Routing\RouterInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 9:56 PM
 */
class ProfileHelper
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $sitemapDir;

    /**
     * @var string
     */
    private $webDir;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     * @param string $sitemapDir
     * @param string $webDir
     */
    public function __construct(RouterInterface $router, $sitemapDir, $webDir)
    {
        $this->router = $router;
        $this->sitemapDir = $this->rtrimDir($sitemapDir);
        $this->webDir = $this->rtrimDir($webDir);
    }

    /**
     * Get sitemap entry file path..
     *
     * @param string $filename
     *
     * @return string
     */
    public function getSitemapEntryFilePath($filename)
    {
        return implode(DIRECTORY_SEPARATOR, array($this->webDir, $this->sitemapDir, $filename));
    }

    public function getSitemapIndexFilePath($filename)
    {
        return implode(DIRECTORY_SEPARATOR, array($this->webDir, $filename));
    }

    /**
     * Get sitemap entry url.
     *
     * @param string $filename
     *
     * @return string
     */
    public function getSitemapEntryFileUrl($filename)
    {
        return implode('/', array($this->getSchemeAndHost(), $this->sitemapDir, $filename));
    }

    /**
     * Get scheme and host.
     *
     * @return string
     */
    public function getSchemeAndHost()
    {
        return $this->router->getContext()->getScheme() . '://' . $this->router->getContext()->getHost();
    }

    /**
     * @param $dir
     *
     * @return string
     */
    private function rtrimDir($dir)
    {
        return rtrim($dir, '/\\');
    }
}
