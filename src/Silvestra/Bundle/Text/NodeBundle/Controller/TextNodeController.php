<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\Text\NodeBundle\Controller;

use Silvestra\Bundle\Text\NodeBundle\Form\Factory\TextNodeFormFactory;
use Silvestra\Bundle\Text\NodeBundle\Form\Handler\TextNodeFormHandler;
use Silvestra\Bundle\Text\NodeBundle\Model\Manager\TextNodeManagerInterface;
use Silvestra\Bundle\Text\NodeBundle\Model\TextNodeInterface;
use Silvestra\Component\Text\Model\Manager\TextManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tadcka\Bundle\SitemapBundle\Frontend\Message\Messages;
use Tadcka\Bundle\SitemapBundle\Frontend\ResponseHelper;
use Tadcka\Component\Tree\Model\NodeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/7/14 12:04 PM
 */
class TextNodeController
{
    /**
     * @var TextNodeFormFactory
     */
    private $formFactory;

    /**
     * @var TextNodeFormHandler
     */
    private $formHandler;

    /**
     * @var ResponseHelper
     */
    private $responseHelper;

    /**
     * @var TextManagerInterface
     */
    private $textManager;

    /**
     * @var TextNodeManagerInterface
     */
    private $textNodeManager;

    /**
     * Constructor.
     *
     * @param TextNodeFormFactory $formFactory
     * @param TextNodeFormHandler $formHandler
     * @param ResponseHelper $responseHelper
     * @param TextManagerInterface $textManager
     * @param TextNodeManagerInterface $textNodeManager
     */
    public function __construct(
        TextNodeFormFactory $formFactory,
        TextNodeFormHandler $formHandler,
        ResponseHelper $responseHelper,
        TextManagerInterface $textManager,
        TextNodeManagerInterface $textNodeManager
    ) {
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
        $this->responseHelper = $responseHelper;
        $this->textManager = $textManager;
        $this->textNodeManager = $textNodeManager;
    }

    /**
     * Silvestra text node index action.
     *
     * @param Request $request
     * @param $nodeId
     *
     * @return Response
     */
    public function indexAction(Request $request, $nodeId)
    {
        $node = $this->responseHelper->getNodeOr404($nodeId);
        $textNode = $this->getTextNode($node);
        $form = $this->formFactory->create($textNode);
        $messages = new Messages();

        if ($this->formHandler->process($request, $form)) {
            $messages->addSuccess($this->formHandler->onSuccess($node));
        }

        if ('json' === $request->getRequestFormat()) {
            $jsonContent = $this->responseHelper->createJsonContent($node);
            $jsonContent->setMessages($this->responseHelper->renderMessages($messages));
            $jsonContent->setTab($this->renderTextNode($form));

            return $this->responseHelper->getJsonResponse($jsonContent);
        }

        return new Response($this->renderTextNode($form, $messages));
    }

    /**
     * Get text node.
     *
     * @param NodeInterface $node
     *
     * @return TextNodeInterface
     */
    private function getTextNode(NodeInterface $node)
    {
        $textNode = $this->textNodeManager->findTextNodeByNode($node);

        if (null === $textNode) {
            $textNode = $this->textNodeManager->create();
            $text = $this->textManager->create();

            $textNode->setText($text);
            $textNode->setNode($node);
            $this->textManager->add($text);
            $this->textNodeManager->add($textNode);
        }

        return $textNode;
    }

    /**
     * Render text node template.
     *
     * @param FormInterface $form
     * @param null|Messages $messages
     *
     * @return string
     */
    private function renderTextNode(FormInterface $form, Messages $messages = null)
    {
        return $this->responseHelper->render(
            'SilvestraTextNodeBundle:TextNode:index.html.twig',
            array(
                'form' => $form->createView(),
                'messages' => $messages,
            )
        );
    }
}
