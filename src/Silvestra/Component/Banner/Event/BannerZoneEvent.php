<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Event;

use Silvestra\Component\Banner\Model\BannerZoneInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/1/15 7:59 PM
 */
class BannerZoneEvent extends Event
{

    /**
     * @var BannerZoneInterface
     */
    private $bannerZone;

    /**
     * @var string
     */
    private $locale;

    /**
     * Constructor.
     *
     * @param BannerZoneInterface $bannerZone
     * @param string $locale
     */
    public function __construct(BannerZoneInterface $bannerZone, $locale)
    {
        $this->bannerZone = $bannerZone;
        $this->locale = $locale;
    }

    /**
     * Get banner zone.
     *
     * @return BannerZoneInterface
     */
    public function getBannerZone()
    {
        return $this->bannerZone;
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
}
