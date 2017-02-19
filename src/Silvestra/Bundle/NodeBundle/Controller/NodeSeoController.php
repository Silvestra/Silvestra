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
use Silvestra\Bundle\NodeBundle\Form\Factory\NodeSeoFormFactory;
use Silvestra\Bundle\NodeBundle\Form\Handler\NodeSeoFormHandler;
use Silvestra\Bundle\NodeBundle\Frontend\ResponseHelper;
use Silvestra\Bundle\NodeBundle\Frontend\Message\Messages;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  14.6.29 20.57
 */
class NodeSeoController
{
    /**
     * @var NodeSeoFormFactory
     */
    private $formFactory;

    /**
     * @var NodeSeoFormHandler
     */
    private $formHandler;

    /**
     * @var ResponseHelper
     */
    private $responseHelper;

    /**
     * Constructor.
     *
     * @param NodeSeoFormFactory $formFactory
     * @param NodeSeoFormHandler $formHandler
     * @param ResponseHelper $responseHelper
     */
    public function __construct(
        NodeSeoFormFactory $formFactory,
        NodeSeoFormHandler $formHandler,
        ResponseHelper $responseHelper
    ) {
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
        $this->responseHelper = $responseHelper;
    }

    public function indexAction(Request $request, $nodeId)
    {
        $node = $this->responseHelper->getNodeOr404($nodeId);
        $messages = new Messages();
        $form = $this->formFactory->create($node);

        if ($this->formHandler->process($request, $form)) {
            $messages->addSuccess($this->formHandler->onSuccess($request->getLocale(), $node));
        }

        if ('json' === $request->getRequestFormat()) {
            $jsonContent = $this->responseHelper->createJsonContent($node);
            $jsonContent->setMessages($this->responseHelper->renderMessages($messages));
            $jsonContent->setTab($this->renderNodeSeoForm($form));

            return $this->responseHelper->getJsonResponse($jsonContent);
        }

        return new Response($this->renderNodeSeoForm($form, $messages));
    }

    /**
     * Render node seo form.
     *
     * @param FormInterface $form
     * @param null|Messages $messages
     *
     * @return string
     */
    private function renderNodeSeoForm(FormInterface $form, Messages $messages = null)
    {
        return $this->responseHelper->render(
            'TadckaSitemapBundle:Node:seo.html.twig',
            array(
                'form' => $form->createView(),
                'messages' => $messages,
            )
        );
    }
}
