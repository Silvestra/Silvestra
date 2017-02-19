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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silvestra\Bundle\NodeBundle\Frontend\TreeHelper;
use Silvestra\Bundle\NodeBundle\Frontend\ResponseHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/23/14 11:12 PM
 */
class TreeController
{
    /**
     * @var ResponseHelper
     */
    private $responseHelper;

    /**
     * @var TreeHelper
     */
    private $treeHelper;

    /**
     * Constructor.
     *
     * @param ResponseHelper $responseHelper
     * @param TreeHelper $treeHelper
     */
    public function __construct(ResponseHelper $responseHelper, TreeHelper $treeHelper)
    {
        $this->responseHelper = $responseHelper;
        $this->treeHelper = $treeHelper;
    }

    /**
     * Get tree node children action.
     *
     * @param Request $request
     * @param int $nodeId
     *
     * @return Response
     */
    public function getChildrenAction(Request $request, $nodeId)
    {
        return $this->responseHelper->getJsonResponse(
            $this->treeHelper->getChildren($this->responseHelper->getNodeOr404($nodeId), $request->getLocale())
        );
    }

    /**
     * Get tree node action.
     *
     * @param Request $request
     * @param int $nodeId
     *
     * @return Response
     */
    public function getNodeAction(Request $request, $nodeId)
    {
        return $this->responseHelper->getJsonResponse(
            $this->treeHelper->getNode($this->responseHelper->getNodeOr404($nodeId), $request->getLocale())
        );
    }

    /**
     * Get tree root children action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getRootAction(Request $request)
    {
        return $this->responseHelper->getJsonResponse($this->treeHelper->getRootNode($request->getLocale()));
    }
}
