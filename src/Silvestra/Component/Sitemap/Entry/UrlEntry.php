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
 * @since 3/24/15 8:21 PM
 */
class UrlEntry extends AbstractEntry implements UrlEntryInterface
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
     * @var string
     */
    private $changeFreq;

    /**
     * @var float
     */
    private $priority;

    /**
     * Constructor.
     *
     * @param string $loc
     * @param null|\DateTime $lasMod
     * @param null|string $changeFreq
     * @param null|string $priority
     */
    public function __construct($loc, \DateTime $lasMod = null, $changeFreq = null, $priority = null)
    {
        $this->loc = $loc;
        $this->lasMod = $this->normalizeLastMod($lasMod);
        $this->changeFreq = $this->normalizeChangeFreq($changeFreq);
        $this->priority = $this->normalizePriority($priority);
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

    /**
     * {@inheritdoc}
     */
    public function getChangeFreq()
    {
        return $this->changeFreq;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Normalize change freq.
     *
     * @param mixed $changeFreq
     *
     * @return string|null
     */
    private function normalizeChangeFreq($changeFreq)
    {
        $changeFreq = strtolower($changeFreq);
        if (in_array($changeFreq, array('always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'))) {
            return $changeFreq;
        }

        return null;
    }

    /**
     * Normalize priority.
     *
     * @param mixed $priority
     *
     * @return float|null
     */
    private function normalizePriority($priority)
    {
        if (is_numeric($priority)) {
            $priority = round(floatval($priority), 1);
            if (0 <= $priority && 1 >= $priority) {
                return $priority;
            }
        }

        return null;
    }
}
