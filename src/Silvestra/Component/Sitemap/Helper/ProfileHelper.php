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
    private $target;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     * @param $target
     */
    public function __construct(RouterInterface $router, $target)
    {
        $this->router = $router;
        $this->target = $target;
    }

    /**
     * Get path.
     *
     * @param string $filename
     *
     * @return string
     */
    public function getFilePath($filename)
    {
        return rtrim($this->target, '/\\') . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * Get url.
     *
     * @param string $filename
     *
     * @return string
     */
    public function getFileUrl($filename)
    {
        return $this->getSchemeAndHost() . '/' . $filename;
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
}
