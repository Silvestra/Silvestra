<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Site;

use Silvestra\Component\Site\Model\SiteInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/18/15 10:42 PM
 */
class SiteEvent extends Event
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var SiteInterface
     */
    private $site;

    /**
     * Constructor.
     *
     * @param string $locale
     * @param SiteInterface $site
     */
    public function __construct($locale, SiteInterface $site)
    {
        $this->locale = $locale;
        $this->site = $site;
    }

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get site.
     *
     * @return SiteInterface
     */
    public function getSite()
    {
        return $this->site;
    }
}
