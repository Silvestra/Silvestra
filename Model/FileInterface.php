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

interface FileInterface
{

    /**
     * Set contentType.
     *
     * @param string $contentType
     *
     * @return FileInterface
     */
    public function setContentType($contentType);

    /**
     * Get contentType.
     *
     * @return string
     */
    public function getContentType();

    /**
     * Set extension.
     *
     * @param string $extension
     *
     * @return FileInterface
     */
    public function setExtension($extension);

    /**
     * Get extension.
     *
     * @return string
     */
    public function getExtension();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return FileInterface
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return FileInterface
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
     * @return FileInterface
     */
    public function setSize($size);

    /**
     * Get size.
     *
     * @return int
     */
    public function getSize();

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return FileInterface
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt();
}
