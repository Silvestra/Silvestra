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

use Silvestra\Component\Banner\Model\BannerInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/1/15 7:59 PM
 */
class BannerEvent extends Event
{

    /**
     * @var BannerInterface
     */
    private $banner;

    /**
     * @var string
     */
    private $locale;

    /**
     * Constructor.
     *
     * @param BannerInterface $banner
     * @param string $locale
     */
    public function __construct(BannerInterface $banner, $locale)
    {
        $this->banner = $banner;
        $this->locale = $locale;
    }

    /**
     * Get banner.
     *
     * @return BannerInterface
     */
    public function getBanner()
    {
        return $this->banner;
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
