<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Sitemap\Entry;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/24/15 8:32 PM
 */
class SitemapEntry extends AbstractEntry implements SitemapEntryInterface
{

    /**
     * @var string
     */
    private $loc;

    /**
     * @var \DateTime
     */
    private $lasMod;

    /**
     * Constructor.
     *
     * @param string $loc
     * @param \DateTime $lasMod
     */
    public function __construct($loc, \DateTime $lasMod)
    {
        $this->loc = $loc;
        $this->lasMod = $this->normalizeLastMod($lasMod);
    }

    /**
     * {@inheritdoc}
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastMod()
    {
        return $this->lasMod;
    }
}
