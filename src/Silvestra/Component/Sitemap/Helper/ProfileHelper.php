<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Helper;

use Silvestra\Component\Sitemap\Profile\ProfileInterface;
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
     * Get scheme and host.
     *
     * @return string
     */
    public function getSchemeAndHost()
    {
        return $this->router->getContext()->getScheme() . '://' . $this->router->getContext()->getHost();
    }

    /**
     * Get get sitemap path.
     *
     * @param ProfileInterface $profile
     *
     * @return string
     */
    public function getSitemapPath(ProfileInterface $profile)
    {
        return rtrim($this->target, '/\\') . DIRECTORY_SEPARATOR . $profile->getName();
    }

    /**
     * Get sitemap url.
     *
     * @param ProfileInterface $profile
     *
     * @return string
     */
    public function getSitemapUrl(ProfileInterface $profile)
    {
        return $this->getSchemeAndHost() . '/' . $profile->getName();
    }
}
