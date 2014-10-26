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

use Silvestra\Bundle\TextBundle\Form\Factory\TextFormFactory;
use Silvestra\Bundle\TextBundle\Form\Handler\TextFormHandler;
use Silvestra\Bundle\Text\NodeBundle\Model\Manager\TextNodeManagerInterface;
use Silvestra\Bundle\Text\NodeBundle\Model\TextNodeInterface;
use Symfony\Component\HttpFoundation\Request;
use Tadcka\Bundle\SitemapBundle\Controller\AbstractController;
use Tadcka\Bundle\SitemapBundle\Frontend\Message\Messages;
use Tadcka\Bundle\SitemapBundle\Frontend\Model\JsonResponseContent;
use Tadcka\Bundle\SitemapBundle\Model\NodeInterface;
use Tadcka\Component\Tree\Event\TreeNodeEvent;
use Tadcka\Component\Tree\TadckaTreeEvents;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/7/14 12:04 PM
 */
class TextNodeController  extends AbstractController
{
    public function indexAction(Request $request, $nodeId)
    {
        $node = $this->getNodeOr404($nodeId);
        $textNode = $this->getTextNode($node);
        $form = $this->getTextFormFactory()->create($textNode->getText());

        $messages = new Messages();
        if ($this->getTextFormHandler()->process($request, $form)) {
            $messages->addSuccess(
                $this->container->get('translator')
                    ->trans('success.text_node_save', array(), 'SilvestraTextNodeBundle')
            );
            $this->getTextNodeManager()->save();

            $this->getEventDispatcher()->dispatch(TadckaTreeEvents::NODE_EDIT_SUCCESS, new TreeNodeEvent($node));
        }

        if ('json' === $request->getRequestFormat()) {
            $jsonResponseContent = new JsonResponseContent($nodeId);
            $jsonResponseContent->setMessages($this->getMessageHtml($messages));
            $jsonResponseContent->setTab(
                $this->render('SilvestraTextNodeBundle:TextNode:index.html.twig', array('form' => $form->createView()))
            );
            $jsonResponseContent->setToolbar($this->getToolbarHtml($node));

            return $this->getJsonResponse($jsonResponseContent);
        }

        return $this->renderResponse(
            'SilvestraTextNodeBundle:TextNode:index.html.twig',
            array(
                'form' => $form->createView(),
                'messages' => $messages,
            )
        );
    }

    /**
     * @return TextFormFactory
     */
    private function getTextFormFactory()
    {
        return $this->container->get('silvestra_text.form_factory.text');
    }

    /**
     * @return TextFormHandler
     */
    private function getTextFormHandler()
    {
        return $this->container->get('silvestra_text.form_handler.text');
    }

    /**
     * @return TextNodeManagerInterface
     */
    private function getTextNodeManager()
    {
        return $this->container->get('silvestra_text_node.manager.text_node');
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
        $textNode = $this->getTextNodeManager()->findTextNodeByNode($node);
        if (null === $textNode) {
            $textNode = $this->getTextNodeManager()->create();
            $textNode->setText($this->container->get('silvestra_text.manager.text')->create());
            $textNode->setNode($node);
            $this->getTextNodeManager()->add($textNode);
        }

        return $textNode;
    }
}
