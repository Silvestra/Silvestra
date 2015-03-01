<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Manager;

use Silvestra\Component\Media\Model\ImageInterface;
use Silvestra\Component\Media\Model\Manager\ImageManager;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 3/1/15 12:14 PM
 */
class InMemoryImageManager extends ImageManager
{
    /**
     * @var ImageManagerInterface
     */
    private $defaultManager;

    /**
     * @var array|ImageInterface[]
     */
    private $images;

    /**
     * Constructor.
     *
     * @param ImageManagerInterface $defaultManager
     */
    public function __construct(ImageManagerInterface $defaultManager)
    {
        $this->defaultManager = $defaultManager;
        $this->images = array();
    }

    /**
     * {@inheritdoc}
     */
    public function findByFilename($filename)
    {
        foreach ($this->images as $image) {
            if ($filename === $image->getFilename()) {
                return $image;
            }
        }

        return $this->defaultManager->findByFilename($filename);
    }

    /**
     * {@inheritdoc}
     */
    public function add(ImageInterface $image, $save = false)
    {
        $this->images[spl_object_hash($image)] = $image;
        $this->defaultManager->add($image, $save);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(ImageInterface $image, $save = false)
    {
        if (isset($this->images[spl_object_hash($image)])) {
            unset($this->images[spl_object_hash($image)]);
        }

        $this->defaultManager->remove($image, $save);
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $this->defaultManager->save();
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->defaultManager->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->defaultManager->getClass();
    }
}
