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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.8.3 12.39
 */
class SitemapController
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param EngineInterface $templating
     * @param TranslatorInterface $translator
     */
    public function __construct(EngineInterface $templating, TranslatorInterface $translator)
    {
        $this->templating = $templating;
        $this->translator = $translator;
    }

    /**
     * Sitemap index action.
     *
     * @return Response
     */
    public function indexAction()
    {
        return new Response(
            $this->templating->render(
                'TadckaSitemapBundle:Sitemap:index.html.twig',
                array('page_header' => $this->translator->trans('sitemap.page_header', array(), 'TadckaSitemapBundle'))
            )
        );
    }
}
