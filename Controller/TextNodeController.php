<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Silvestra <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\TextNodeBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tadcka\Bundle\SitemapBundle\Frontend\Message\Messages;
use Tadcka\Bundle\SitemapBundle\Model\NodeInterface;
use Silvestra\Bundle\TextNodeBundle\Model\Manager\TextNodeManagerInterface;
use Silvestra\Bundle\TextNodeBundle\Model\TextNodeInterface;
use Tadcka\Component\Tree\Event\TreeNodeEvent;
use Tadcka\Component\Tree\TadckaTreeEvents;
use Tadcka\TextBundle\Form\Factory\TextFormFactory;
use Tadcka\TextBundle\Form\Handler\TextFormHandler;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 9/7/14 12:04 PM
 */
class TextNodeController extends ContainerAware
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

            $this->container->get('event_dispatcher')
                ->dispatch(TadckaTreeEvents::NODE_EDIT_SUCCESS, new TreeNodeEvent($node));
        }

        return $this->renderResponse(
            '@SilvestraTextNode/TextNode/index.html.twig',
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
        return $this->container->get('tadcka_text.form_factory.text');
    }

    /**
     * @return TextFormHandler
     */
    private function getTextFormHandler()
    {
        return $this->container->get('tadcka_text.form_handler.text');
    }

    /**
     * @return TextNodeManagerInterface
     */
    private function getTextNodeManager()
    {
        return $this->container->get('silvestra_text_node.manager.text_node');
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
        return new Response($this->container->get('templating')->render($name, $parameters));
    }

    /**
     * Get node or 404 http status code.
     *
     * @param int $id
     *
     * @return null|NodeInterface
     *
     * @throws NotFoundHttpException
     */
    private function getNodeOr404($id)
    {
        $node = $this->container->get('tadcka_sitemap.manager.node')->findNodeById($id);
        if (null === $node) {
            throw new NotFoundHttpException('Not found node!');
        }

        return $node;
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
            $textNode->setText($this->container->get('tadcka_text.manager.text')->create());
            $textNode->setNode($node);
            $this->getTextNodeManager()->add($textNode);
        }

        return $textNode;
    }
}
