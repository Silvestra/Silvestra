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
use Silvestra\Bundle\NodeBundle\Form\Factory\NodeFormFactory;
use Silvestra\Bundle\NodeBundle\Form\Handler\NodeFormHandler;
use Silvestra\Bundle\NodeBundle\Frontend\Message\Messages;
use Silvestra\Bundle\NodeBundle\Handler\NodeDeleteHandler;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Model\Manager\NodeManagerInterface;
use Silvestra\Bundle\NodeBundle\Frontend\ResponseHelper;
use Tadcka\Component\Tree\Model\TreeInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  4/2/14 11:11 PM
 */
class NodeController
{
    /**
     * @var NodeDeleteHandler
     */
    private $nodeDeleteHandler;

    /**
     * @var NodeFormFactory
     */
    private $nodeFormFactory;

    /**
     * @var NodeFormHandler
     */
    private $nodeFormHandler;

    /**
     * @var NodeManagerInterface
     */
    private $nodeManager;

    /**
     * @var ResponseHelper
     */
    private $responseHelper;

    /**
     * Constructor.
     *
     * @param NodeDeleteHandler $nodeDeleteHandler
     * @param NodeFormFactory $nodeFormFactory
     * @param NodeFormHandler $nodeFormHandler
     * @param NodeManagerInterface $nodeManager
     * @param ResponseHelper $responseHelper
     */
    public function __construct(
        NodeDeleteHandler $nodeDeleteHandler,
        NodeFormFactory $nodeFormFactory,
        NodeFormHandler $nodeFormHandler,
        NodeManagerInterface $nodeManager,
        ResponseHelper $responseHelper
    ) {
        $this->nodeDeleteHandler = $nodeDeleteHandler;
        $this->nodeFormFactory = $nodeFormFactory;
        $this->nodeFormHandler = $nodeFormHandler;
        $this->nodeManager = $nodeManager;
        $this->responseHelper = $responseHelper;
    }


    /**
     * Sitemap tree node create action.
     *
     * @param Request $request
     * @param int $parentId
     *
     * @return Response
     */
    public function createAction(Request $request, $parentId)
    {
        $parent = $this->responseHelper->getNodeOr404($parentId);
        $node = $this->createNode($parent->getTree(), $parent);
        $form = $this->nodeFormFactory->create($node);

        if ($this->nodeFormHandler->process($request, $form)) {
            $messages = new Messages();
            $messages->addSuccess($this->nodeFormHandler->onCreateSuccess($request->getLocale(), $node));

            if ('json' === $request->getRequestFormat()) {
                $jsonContent = $this->responseHelper->createJsonContent($node);
                $jsonContent->setMessages($this->responseHelper->renderMessages($messages));

                return $this->responseHelper->getJsonResponse($jsonContent);
            }

            return new Response($this->responseHelper->renderMessages($messages));
        }

        if ('json' === $request->getRequestFormat()) {
            $jsonContent = $this->responseHelper->createJsonContent($node);
            $jsonContent->setContent($this->renderNodeForm($form));

            return $this->responseHelper->getJsonResponse($jsonContent);
        }

        return new Response($this->renderNodeForm($form));
    }

    /**
     * Sitemap tree node edit action.
     *
     * @param Request $request
     * @param int $nodeId
     *
     * @return Response
     */
    public function editAction(Request $request, $nodeId)
    {
        $node = $this->responseHelper->getNodeOr404($nodeId);
        $form = $this->nodeFormFactory->create($node);
        $jsonContent = $this->responseHelper->createJsonContent($node);
        $messages = new Messages();

        if ($this->nodeFormHandler->process($request, $form)) {
            $messages->addSuccess($this->nodeFormHandler->onEditSuccess($request->getLocale(), $node));
            $jsonContent->setMessages($this->responseHelper->renderMessages($messages));
        }

        if ('json' === $request->getRequestFormat()) {
            $jsonContent->setTab($this->renderNodeForm($form));

            return $this->responseHelper->getJsonResponse($jsonContent);
        }

        return new Response($this->renderNodeForm($form, $messages));
    }

    /**
     * Sitemap tree node delete action.
     *
     * @param Request $request
     * @param int $nodeId
     *
     * @return Response
     */
    public function deleteAction(Request $request, $nodeId)
    {
        $node = $this->responseHelper->getNodeOr404($nodeId);
        $jsonContent = $this->responseHelper->createJsonContent($node);

        if ($this->nodeDeleteHandler->process($node, $request)) {
            $messages = new Messages();
            $messages->addSuccess($this->nodeDeleteHandler->onSuccess($request->getLocale(), $node));

            if ('json' === $request->getRequestFormat()) {
                $jsonContent->setMessages($this->responseHelper->renderMessages($messages));

                return $this->responseHelper->getJsonResponse($jsonContent);
            }

            return new Response($this->responseHelper->renderMessages($messages));
        }

        if ('json' === $request->getRequestFormat()) {
            $jsonContent->setContent($this->renderNodeDeleteConfirm($node));

            return $this->responseHelper->getJsonResponse($jsonContent);
        }

        return new Response($this->renderNodeDeleteConfirm($node));
    }

    /**
     * Create node.
     *
     * @param TreeInterface $tree
     * @param NodeInterface $parent
     *
     * @return NodeInterface
     */
    private function createNode(TreeInterface $tree, NodeInterface $parent)
    {
        $node = $this->nodeManager->create();

        $node->setTree($tree);
        $node->setParent($parent);
        $this->nodeManager->add($node);

        return $node;
    }

    /**
     * Render node form.
     *
     * @param FormInterface $form
     * @param null|Messages $messages
     *
     * @return string
     */
    private function renderNodeForm(FormInterface $form, Messages $messages = null)
    {
        return  $this->responseHelper->render(
            'TadckaSitemapBundle:Node:form.html.twig',
            array(
                'form' => $form->createView(),
                'messages' => $messages,
            )
        );
    }

    /**
     * Render node delete confirm.
     *
     * @param NodeInterface $node
     *
     * @return string
     */
    private function renderNodeDeleteConfirm(NodeInterface $node)
    {
        return $this->responseHelper->render(
            'TadckaSitemapBundle:Node:delete.html.twig',
            array('node_id' => $node->getId())
        );
    }
}
