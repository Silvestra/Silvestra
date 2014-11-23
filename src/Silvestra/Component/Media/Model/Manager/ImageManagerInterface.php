<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Model\Manager;

use Silvestra\Component\Media\Model\ImageInterface;

interface ImageManagerInterface
{
    /**
     * Create new Image object.
     *
     * @return ImageInterface
     */
    public function create();

    /**
     * Add Image object from persistent layer.
     *
     * @param ImageInterface $image
     * @param bool $save
     */
    public function add(ImageInterface $image, $save = false);

    /**
     * Remove Image object from persistent layer.
     *
     * @param ImageInterface $image
     * @param bool $save
     */
    public function remove(ImageInterface $image, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear Image objects from persistent layer.
     */
    public function clear();

    /**
     * Get Image object class name.
     *
     * @return string
     */
    public function getClass();
}
