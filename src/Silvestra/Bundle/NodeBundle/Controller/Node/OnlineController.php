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

use Symfony\Component\HttpFoundation\Response;
use Silvestra\Bundle\NodeBundle\Frontend\Message\Messages;
use Silvestra\Bundle\NodeBundle\Handler\NodeOnlineHandler;
use Tadcka\Component\Tree\Model\Manager\NodeManagerInterface;
use Tadcka\Component\Tree\Model\NodeInterface;
use Silvestra\Bundle\NodeBundle\Frontend\ResponseHelper;
use Silvestra\Bundle\NodeBundle\Routing\RouterHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.10.23 16.11
 */
class OnlineController
{
    /**
     * @var NodeManagerInterface
     */
    private $nodeManager;

    /**
     * @var NodeOnlineHandler
     */
    private $nodeOnlineHandler;

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
     * @param NodeManagerInterface $nodeManager
     * @param NodeOnlineHandler $nodeOnlineHandler
     * @param ResponseHelper $responseHelper
     * @param RouterHelper $routerHelper
     */
    public function __construct(
        NodeManagerInterface $nodeManager,
        NodeOnlineHandler $nodeOnlineHandler,
        ResponseHelper $responseHelper,
        RouterHelper $routerHelper
    ) {
        $this->nodeManager = $nodeManager;
        $this->nodeOnlineHandler = $nodeOnlineHandler;
        $this->responseHelper = $responseHelper;
        $this->routerHelper = $routerHelper;
    }

    /**
     * Sitemap node online index action.
     *
     * @param string $locale
     * @param int $nodeId
     *
     * @return Response
     */
    public function indexAction($locale, $nodeId)
    {
        $node = $this->responseHelper->getNodeOr404($nodeId);
        $jsonContent = $this->responseHelper->createJsonContent($node);
        $messages = new Messages();

        if ($this->nodeOnlineHandler->process($locale, $messages, $node)) {
            $messages->addSuccess($this->nodeOnlineHandler->onSuccess($locale, $node));
            $jsonContent->setToolbar($this->renderToolbar($node));

            $this->nodeManager->save();
        }
        $jsonContent->setMessages($this->responseHelper->renderMessages($messages));

        return $this->responseHelper->getJsonResponse($jsonContent);
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
