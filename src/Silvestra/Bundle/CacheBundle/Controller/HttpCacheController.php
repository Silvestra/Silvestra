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
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HttpCacheController extends ContainerAware
{
    public function invalidateAllAction(Request $request)
    {
        if ($request->isMethod('DELETE')) {
            try {
                $this->getHttpCacheManager()->invalidateAll();
            } catch (\Exception $e) {
                return new JsonResponse(array('success' => false));
            }

            return new JsonResponse(array('success' => true));
        }

        throw new NotFoundHttpException();
    }

    /**
     * @return HttpCacheManager
     */
    private function getHttpCacheManager()
    {
        return $this->container->get('silvestra_cache.http_cache.manager');
    }
}
