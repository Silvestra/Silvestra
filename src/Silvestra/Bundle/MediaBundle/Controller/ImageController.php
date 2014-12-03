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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/11/14 9:27 PM
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

        return $this->renderResponse('SilvestraMediaBundle:Form:modal.html.twig', array('image' => $image));
    }

    /**
     * Render response.
     *
     * @param string $name
     * @param array $parameters
     *
     * @return Response
     */
    private function renderResponse($name, array $parameters = array())
    {
        return new Response($this->templating->render($name, $parameters));
    }
}
