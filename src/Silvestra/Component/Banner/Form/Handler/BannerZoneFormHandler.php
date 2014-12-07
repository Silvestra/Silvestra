<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Form\Handler;

use Silvestra\Component\Banner\Model\Manager\BannerZoneManagerInterface;
use Silvestra\Component\Notification\AlertManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/5/14 11:39 PM
 */
class BannerZoneFormHandler
{
    /**
     * @var AlertManager
     */
    private $alertManager;

    /**
     * @var BannerZoneManagerInterface
     */
    private $bannerZoneManager;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param AlertManager $alertManager
     * @param BannerZoneManagerInterface $bannerZoneManager
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     */
    public function __construct(
        AlertManager $alertManager,
        BannerZoneManagerInterface $bannerZoneManager,
        RouterInterface $router,
        TranslatorInterface $translator
    ) {
        $this->alertManager = $alertManager;
        $this->bannerZoneManager = $bannerZoneManager;
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * Process banner zone form.
     *
     * @param FormInterface $form
     * @param Request $request
     *
     * @return bool
     */
    public function process(FormInterface $form, Request $request)
    {
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->bannerZoneManager->add($form->getData());

                return true;
            }
        }

        return false;
    }

    /**
     * On success.
     *
     * @return RedirectResponse
     */
    public function onSuccess()
    {
        $alert = $this->alertManager->create();

        $alert->addSuccess($this->translator->trans('success.save_banner_zone', array(), 'SilvestraBanner'));
        $this->alertManager->setFlashAlert($alert);

        return new RedirectResponse($this->router->generate('silvestra_banner.banner_zone_list'));
    }
}
