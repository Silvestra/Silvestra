<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Admin\Menu;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/11/14 1:39 AM
 */
class AdminMenuItem
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var int
     */
    private $priority;

    /**
     * @var array|AdminMenuItem[]
     */
    private $children = array();

    /**
     * Constructor.
     *
     * @param string $title
     * @param string $uri
     * @param string $icon
     * @param int $priority
     */
    public function __construct($title, $uri, $icon = null, $priority = 0)
    {
        $this->title = $title;
        $this->uri = $uri;
        $this->icon = $icon;
        $this->priority = $priority;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get uri.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Get priority.
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set children.
     *
     * @param array|AdminMenuItem[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * Get children.
     *
     * @return array|AdminMenuItem[]
     */
    public function getChildren()
    {
        uasort(
            $this->children,
            function (AdminMenuItem $first, AdminMenuItem $second) {
                if ($first->getPriority() <= $second->getPriority()) {
                    return 1;
                }

                return -1;
            }
        );

        return $this->children;
    }

    /**
     * Add child.
     *
     * @param AdminMenuItem $child
     */
    public function addChild(AdminMenuItem $child)
    {
        $this->children[] = $child;
    }
}
