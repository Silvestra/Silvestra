<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Controller;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Silvestra\Bundle\NodeBundle\Form\Factory\NodeRedirectRouteFormFactory;
use Silvestra\Bundle\NodeBundle\Form\Handler\NodeRedirectRouteFormHandler;
use Silvestra\Bundle\NodeBundle\Frontend\Message\Messages;
use Silvestra\Bundle\NodeBundle\Frontend\ResponseHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/1/14 7:47 PM
 */
class NodeRedirectRouteController
{
    /**
     * @var NodeRedirectRouteFormFactory
     */
    private $formFactory;

    /**
     * @var NodeRedirectRouteFormHandler
     */
    private $formHandler;

    /**
     * @var ResponseHelper
     */
    private $responseHelper;

    /**
     * Constructor.
     *
     * @param NodeRedirectRouteFormFactory $formFactory
     * @param NodeRedirectRouteFormHandler $formHandler
     * @param ResponseHelper $responseHelper
     */
    public function __construct(
        NodeRedirectRouteFormFactory $formFactory,
        NodeRedirectRouteFormHandler $formHandler,
        ResponseHelper $responseHelper
    ) {
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
        $this->responseHelper = $responseHelper;
    }


    public function indexAction(Request $request, $nodeId)
    {
        $node = $this->responseHelper->getNodeOr404($nodeId);

        if ('redirect' !== $node->getType()) {
            throw new NotFoundHttpException('Node type is not redirect!');
        }

        $form = $this->formFactory->create($node);
        $jsonContent = $this->responseHelper->createJsonContent($node);
        $messages = new Messages();

        if ($this->formHandler->process($request, $form)) {
            $message = $this->formHandler->onSuccess($request->getLocale(), $node);
            $messages->addSuccess($message);

            // Hack... Form with new data.
            $form = $this->formFactory->create($node);
        }

        if ('json' === $request->getRequestFormat()) {
            $jsonContent->setMessages($this->responseHelper->renderMessages($messages));
            $jsonContent->setTab($this->renderNodeRedirectRoute($form));

            return $this->responseHelper->getJsonResponse($jsonContent);
        }

        return new Response($this->renderNodeRedirectRoute($form, $messages));
    }

    /**
     * Render node redirect route template.
     *
     * @param FormInterface $form
     * @param Messages $messages
     *
     * @return string
     */
    private function renderNodeRedirectRoute(FormInterface $form, Messages $messages = null)
    {
        return $this->responseHelper->render(
            'TadckaSitemapBundle:Node:redirect_route.html.twig',
            array('form' => $form->createView(), 'messages' => $messages)
        );
    }
}
