<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Form\DataTransformer;

use Silvestra\Component\Media\Model\ImageInterface;
use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 4:04 PM
 */
class ImageTransformer implements DataTransformerInterface
{
    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * Constructor.
     *
     * @param ImageManagerInterface $imageManager
     */
    public function __construct(ImageManagerInterface $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * Transform.
     *
     * @param ImageInterface $image
     *
     * @return ImageInterface
     */
    public function transform($image)
    {
        return $image;
    }

    /**
     * Reverse transform.
     *
     * @param ImageInterface $image
     *
     * @return ImageInterface
     *
     * @throws TransformationFailedException
     */
    public function reverseTransform($image)
    {
        $filename = $image->getFilename();

        if (empty($filename)) {
            return null;
        }

        $image = $this->imageManager->findByFilename($filename);

        if (null === $image) {
            throw new TransformationFailedException();
        }

        $image->setTemporary(false);

        return $image;
    }
}
