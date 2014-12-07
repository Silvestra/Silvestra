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

use Silvestra\Component\Banner\Model\BannerInterface;
use Silvestra\Component\Banner\Model\Manager\BannerManagerInterface;
use Silvestra\Component\Notification\AlertManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/6/14 1:47 PM
 */
class BannerFormHandler
{
    /**
     * @var AlertManager
     */
    private $alertManager;

    /**
     * @var BannerManagerInterface
     */
    private $bannerManager;

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
     * @param BannerManagerInterface $bannerManager
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     */
    public function __construct(
        AlertManager $alertManager,
        BannerManagerInterface $bannerManager,
        RouterInterface $router,
        TranslatorInterface $translator
    ) {
        $this->alertManager = $alertManager;
        $this->bannerManager = $bannerManager;
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * Process banner form.
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
                $this->bannerManager->add($form->getData());

                return true;
            }
        }

        return false;
    }

    /**
     * On success.
     *
     * @param BannerInterface $banner
     *
     * @return RedirectResponse
     */
    public function onSuccess(BannerInterface $banner)
    {
        $alert = $this->alertManager->create();

        $alert->addSuccess($this->translator->trans('success.save_banner', array(), 'SilvestraBanner'));
        $this->alertManager->setFlashAlert($alert);

        return new RedirectResponse($this->router->generate(
            'silvestra_banner.banner_list',
            array('zoneId' => $banner->getZone()->getId())
        ));
    }
}
