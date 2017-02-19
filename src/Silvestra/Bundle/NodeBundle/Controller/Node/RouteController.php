<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Controller\Node;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Silvestra\Bundle\NodeBundle\Form\Factory\NodeRouteFormFactory;
use Silvestra\Bundle\NodeBundle\Form\Handler\NodeRouteFormHandler;
use Silvestra\Bundle\NodeBundle\Frontend\Message\Messages;
use Silvestra\Bundle\NodeBundle\Frontend\ResponseHelper;
use Tadcka\Component\Tree\Model\NodeInterface;
use Silvestra\Bundle\NodeBundle\Routing\RouterHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since  14.10.25 22.07
 */
class RouteController
{
    /**
     * @var NodeRouteFormFactory
     */
    private $formFactory;

    /**
     * @var NodeRouteFormHandler
     */
    private $formHandler;

    /**
     * @var ResponseHelper
     */
    private $responseHelper;

    /**
     * @var RouterHelper
     */
    private $routerHelper;

    /**
     * Constructor.
     *
     * @param NodeRouteFormFactory $formFactory
     * @param NodeRouteFormHandler $formHandler
     * @param ResponseHelper $responseHelper
     * @param RouterHelper $routerHelper
     */
    public function __construct(
        NodeRouteFormFactory $formFactory,
        NodeRouteFormHandler $formHandler,
        ResponseHelper $responseHelper,
        RouterHelper $routerHelper
    ) {
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
        $this->responseHelper = $responseHelper;
        $this->routerHelper = $routerHelper;
    }


    public function indexAction(Request $request, $nodeId)
    {
        $node = $this->responseHelper->getNodeOr404($nodeId);

        if (false === $this->routerHelper->hasController($node->getType())) {
            throw new NotFoundHttpException('Node don\'t have controller.');
        }

        $form = $this->formFactory->create($node);
        $jsonContent = $this->responseHelper->createJsonContent($node);
        $messages = new Messages();

        if ($this->formHandler->process($request, $form)) {
            $message = $this->formHandler->onSuccess($request->getLocale(), $node);
            $messages->addSuccess($message);
            if ('json' === $request->getRequestFormat()) {
                $jsonContent->setToolbar($this->renderToolbar($node));
            }

            // Hack... Form with new data.
            $form = $this->formFactory->create($node);
        }

        if ('json' === $request->getRequestFormat()) {
            $jsonContent->setMessages($this->responseHelper->renderMessages($messages));
            $jsonContent->setTab($this->renderNodeRoute($form));

            return $this->responseHelper->getJsonResponse($jsonContent);
        }

        return new Response($this->renderNodeRoute($form, $messages));
    }

    /**
     * Render node route template.
     *
     * @param FormInterface $form
     * @param null|Messages $messages
     *
     * @return string
     */
    private function renderNodeRoute(FormInterface $form, Messages $messages = null)
    {
        return $this->responseHelper->render(
            'TadckaSitemapBundle:Node:route.html.twig',
            array('form' => $form->createView(), 'messages' => $messages)
        );
    }

    /**
     * Render toolbar template.
     *
     * @param NodeInterface $node
     *
     * @return string
     */
    private function renderToolbar(NodeInterface $node)
    {
        return $this->responseHelper->render(
            'TadckaSitemapBundle:Sitemap:toolbar.html.twig',
            array(
                'node' => $node,
                'multi_language_enabled' => $this->routerHelper->multiLanguageIsEnabled(),
                'multi_language_locales' => $this->routerHelper->getMultiLanguageLocales(),
                'has_controller' => $this->routerHelper->hasController($node->getType()),
            )
        );
    }
}
