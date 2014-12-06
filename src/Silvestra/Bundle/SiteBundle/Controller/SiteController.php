<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SiteBundle\Controller;

use Silvestra\Component\Site\Form\Factory\SiteFormFactory;
use Silvestra\Component\Site\Form\Handler\SiteFormHandler;
use Silvestra\Component\Site\Model\Manager\SiteManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class SiteController
{
    /**
     * @var SiteFormFactory
     */
    private $formFactory;

    /**
     * @var SiteFormHandler
     */
    private $formHandler;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var SiteManagerInterface
     */
    private $siteManager;

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
     * @param SiteFormFactory $formFactory
     * @param SiteFormHandler $formHandler
     * @param RouterInterface $router
     * @param SiteManagerInterface $siteManager
     * @param EngineInterface $templating
     * @param TranslatorInterface $translator
     */
    public function __construct(
        SiteFormFactory $formFactory,
        SiteFormHandler $formHandler,
        RouterInterface $router,
        SiteManagerInterface $siteManager,
        EngineInterface $templating,
        TranslatorInterface $translator
    ) {
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
        $this->router = $router;
        $this->siteManager = $siteManager;
        $this->templating = $templating;
        $this->translator = $translator;
    }

    public function indexAction(Request $request)
    {
        $site = $this->siteManager->find();

        if (null === $site) {
            $site = $this->siteManager->create();
        }

        $form = $this->formFactory->create($site);

        if ($this->formHandler->process($request, $form)) {
            $this->siteManager->save();
            $this->formHandler->onSuccess();

            return new RedirectResponse($this->router->generate('silvestra_site'));
        }

        return new Response($this->renderSite($form));
    }

    /**
     * Render site template.
     *
     * @param FormInterface $form
     *
     * @return string
     */
    private function renderSite(FormInterface $form)
    {
        return $this->templating->render(
            'SilvestraSiteBundle:Site:index.html.twig',
            array(
                'form' => $form->createView(),
                'page_header' => $this->translator->trans('site', array(), 'SilvestraSite')
            )
        );
    }
}
