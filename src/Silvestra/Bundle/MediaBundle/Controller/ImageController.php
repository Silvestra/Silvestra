<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\MediaBundle\Controller;

use Silvestra\Component\Media\Model\Manager\ImageManagerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class ImageController
{
    /**
     * @var ImageManagerInterface
     */
    private $imageManager;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * Constructor.
     *
     * @param ImageManagerInterface $imageManager
     * @param EngineInterface $templating
     */
    public function __construct(ImageManagerInterface $imageManager, EngineInterface $templating)
    {
        $this->imageManager = $imageManager;
        $this->templating = $templating;
    }

    public function modalAction(Request $request)
    {
        $image = null;

        if (null !== $filename = $request->get('filename', null)) {
            $image = $this->imageManager->findByFilename($filename);
        }

        return $this->templating->renderResponse('SilvestraMediaBundle:Form:modal.html.twig', array('image' => $image));
    }
}
