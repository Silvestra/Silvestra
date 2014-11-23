<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 1:38 PM
 */
class ImageConfig
{
    /**
     * @var array
     */
    private $availableMimeTypes;

    /**
     * @var bool
     */
    private $defaultCropperEnabled;

    /**
     * @var string
     */
    private $defaultResizeStrategy;

    /**
     * File size MB.
     *
     * @var int
     */
    private $maxFileSize;

    /**
     * @var int
     */
    private $maxHeight;

    /**
     * @var int
     */
    private $maxWidth;

    /**
     * @var int
     */
    private $minHeight;

    /**
     * @var int
     */
    private $minWidth;

    /**
     * Constructor.
     *
     * @param array $availableMimeTypes
     * @param bool $defaultCropperEnabled
     * @param string $defaultResizeStrategy
     * @param int $maxFileSize
     * @param int $maxHeight
     * @param int $maxWidth
     * @param int $minHeight
     * @param int $minWidth
     */
    public function __construct(
        array $availableMimeTypes,
        $defaultCropperEnabled,
        $defaultResizeStrategy,
        $maxFileSize,
        $maxHeight,
        $maxWidth,
        $minHeight,
        $minWidth
    ) {
        $this->availableMimeTypes = $availableMimeTypes;
        $this->defaultCropperEnabled = $defaultCropperEnabled;
        $this->defaultResizeStrategy = $defaultResizeStrategy;
        $this->maxFileSize = $maxFileSize;
        $this->maxHeight = $maxHeight;
        $this->maxWidth = $maxWidth;
        $this->minHeight = $minHeight;
        $this->minWidth = $minWidth;
    }

    /**
     * Get available mime types.
     *
     * @return array
     */
    public function getAvailableMimeTypes()
    {
        return $this->availableMimeTypes;
    }

    /**
     * Check if cropper by default is enabled.
     *
     * @return bool
     */
    public function isDefaultCropperEnabled()
    {
        return $this->defaultCropperEnabled;
    }

    /**
     * Get default resize strategy.
     *
     * @return string
     */
    public function getDefaultResizeStrategy()
    {
        return $this->defaultResizeStrategy;
    }

    /**
     * @return int
     */
    public function getMaxFileSize()
    {
        return $this->maxFileSize;
    }

    /**
     * Get max height.
     *
     * @return int
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * Get max width.
     *
     * @return int
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * Get min height.
     *
     * @return int
     */
    public function getMinHeight()
    {
        return $this->minHeight;
    }

    /**
     * Get min width.
     *
     * @return int
     */
    public function getMinWidth()
    {
        return $this->minWidth;
    }
}
