<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NodeBundle\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tadcka\Component\Tree\Model\NodeInterface;
use Tadcka\Component\Tree\Model\NodeTranslationInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 8/7/14 8:40 PM
 */
interface PageNodeProviderInterface
{
    /**
     * Get page node or 404 response status code.
     *
     * @param Request $request
     *
     * @return NodeInterface
     *
     * @throws NotFoundHttpException
     */
    public function getNodeOr404(Request $request);

    /**
     * Get page node translation or 404 response status code.
     *
     * @param Request $request
     *
     * @return null|NodeTranslationInterface
     *
     * @throws NotFoundHttpException
     */
    public function getNodeTranslationOr404(Request $request);
}
