<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\CacheBundle\Controller;

use Silvestra\Component\Cache\Http\HttpCacheManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HttpCacheController
{

    /**
     * @var HttpCacheManager
     */
    private $httpCacheManager;

    /**
     * Constructor.
     *
     * @param HttpCacheManager $httpCacheManager
     */
    public function __construct(HttpCacheManager $httpCacheManager)
    {
        $this->httpCacheManager = $httpCacheManager;
    }

    public function invalidateAllAction(Request $request)
    {
        if ($request->isMethod('DELETE')) {
            $success = true;

            try {
                $this->httpCacheManager->invalidateAll();
            } catch (\Exception $e) {
                $success = false;
            }

            return new JsonResponse(array('success' => $success));
        }

        throw new NotFoundHttpException();
    }
}
