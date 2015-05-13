<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Profile;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 9:10 PM
 */
class ProfileRegistry
{
    /**
     * @var array|ProfileInterface[]
     */
    private $profiles = array();

    /**
     * Add profile.
     *
     * @param ProfileInterface $profile
     */
    public function add(ProfileInterface $profile)
    {
        $this->profiles[$profile->getName()] = $profile;
    }

    /**
     * Get profiles.
     *
     * @return array|ProfileInterface[]
     */
    public function getProfiles()
    {
        return $this->profiles;
    }
}
