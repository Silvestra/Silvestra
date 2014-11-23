<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Model;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 3:27 PM
 */
interface ImageInterface
{
    /**
     * Get created at.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set cropper coordinates.
     *
     * @param array $cropperCoordinates
     *
     * @return ImageInterface
     */
    public function setCropperCoordinates(array $cropperCoordinates);

    /**
     * Get cropper coordinates.
     *
     * @return array
     */
    public function getCropperCoordinates();

    /**
     * Set mime type.
     *
     * @param string $mimeType
     *
     * @return ImageInterface
     */
    public function setMimeType($mimeType);

    /**
     * Get mime type.
     *
     * @return string
     */
    public function getMimeType();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return ImageInterface
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set original path.
     *
     * @param string $originalPath
     *
     * @return ImageInterface
     */
    public function setOriginalPath($originalPath);

    /**
     * Get original path.
     *
     * @return string
     */
    public function getOriginalPath();

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return ImageInterface
     */
    public function setPath($path);

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath();

    /**
     * Set size.
     *
     * @param int $size
     *
     * @return ImageInterface
     */
    public function setSize($size);

    /**
     * Get size.
     *
     * @return int
     */
    public function getSize();

    /**
     * Set temporary.
     *
     * @param bool $temporary
     *
     * @return ImageInterface
     */
    public function setTemporary($temporary);

    /**
     * Get temporary.
     *
     * @return bool
     */
    public function isTemporary();

    /**
     * Set updated at.
     *
     * @param \DateTime $updatedAt
     *
     * @return ImageInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Get updated at.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();
}
