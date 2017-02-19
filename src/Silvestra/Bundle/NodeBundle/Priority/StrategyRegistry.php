<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Priority;

use Silvestra\Bundle\NodeBundle\Exception\RuntimeException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/21/15 12:17 AM
 */
class StrategyRegistry
{

    /**
     * @var array|PriorityStrategyInterface[]
     */
    private $strategies;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->strategies = array();
    }

    /**
     * Set priority strategy.
     *
     * @param PriorityStrategyInterface $strategy
     */
    public function set(PriorityStrategyInterface $strategy)
    {
        $this->strategies[$strategy->getName()] = $strategy;
    }

    /**
     * Get priority strategy.
     *
     * @param string $name
     *
     * @return PriorityStrategyInterface
     *
     * @throws RuntimeException
     */
    public function get($name)
    {
        if (false === isset($this->strategies[$name])) {
            throw new RuntimeException(sprintf('Priority strategy %s not found!', $name));
        }

        return $this->strategies[$name];
    }
}
