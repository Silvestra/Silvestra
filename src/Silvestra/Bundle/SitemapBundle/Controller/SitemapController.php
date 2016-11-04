<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SitemapBundle\Controller;

use Silvestra\Component\Sitemap\Dumper\SitemapDumper;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 7/27/15 10:05 PM
 */
class SitemapController
{

    /**
     * @var SitemapDumper
     */
    private $dumper;

    /**
     * @var array
     */
    private $httpCache;

    /**
     * Constructor.
     *
     * @param SitemapDumper $dumper
     * @param array $httpCache
     */
    public function __construct(SitemapDumper $dumper, array $httpCache)
    {
        $this->dumper = $dumper;
        $this->httpCache = $httpCache;
    }

    public function indexAction()
    {
        $response = new Response($this->dumper->dump(), 200, array('Content-Type' => 'application/xml'));
        $response->setPublic();
        $response->setClientTtl($this->httpCache['ttl']);

        return $response;
    }
}
