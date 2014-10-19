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

use Silvestra\Component\Media\Model\FileInterface;

interface FileManagerInterface
{
    /**
     * Create new File object.
     *
     * @return FileInterface
     */
    public function create();

    /**
     * Add File object from persistent layer.
     *
     * @param FileInterface $file
     * @param bool $save
     */
    public function add(FileInterface $file, $save = false);

    /**
     * Remove File object from persistent layer.
     *
     * @param FileInterface $file
     * @param bool $save
     */
    public function remove(FileInterface $file, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear File objects from persistent layer.
     */
    public function clear();

    /**
     * Get File object class name.
     *
     * @return string
     */
    public function getClass();
}
