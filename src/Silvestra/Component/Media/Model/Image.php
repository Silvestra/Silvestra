<?php

/*
 * This file is part of the Tadcka package.
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
 * @since 11/23/14 1:32 PM
 */
class Image implements ImageInterface
{
    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var array
     */
    protected $cropperCoordinates;

    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $originalPath;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var bool
     */
    protected $temporary;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
        $this->cropperCoordinates = array();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCropperCoordinates(array $cropperCoordinates)
    {
        $this->cropperCoordinates = $cropperCoordinates;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCropperCoordinates()
    {
        return $this->cropperCoordinates;
    }

    /**
     * {@inheritdoc}
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginalPath($originalPath)
    {
        $this->originalPath = $originalPath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalPath()
    {
        return $this->originalPath;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function setTemporary($temporary)
    {
        $this->temporary = $temporary;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isTemporary()
    {
        return $this->temporary;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
