<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Site\Form\Handler;

use Silvestra\Component\Notification\AlertManager;
use Silvestra\Component\Site\Model\Manager\SiteManagerInterface;
use Silvestra\Component\Site\Model\SiteInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/28/14 10:34 PM
 */
class SiteFormHandler
{
    /**
     * @var SiteManagerInterface
     */
    private $siteManager;

    /**
     * @var AlertManager
     */
    private $alertManager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param SiteManagerInterface $siteManager
     * @param AlertManager $alertManager
     * @param TranslatorInterface $translator
     */
    public function __construct(
        SiteManagerInterface $siteManager,
        AlertManager $alertManager,
        TranslatorInterface $translator
    ) {
        $this->siteManager = $siteManager;
        $this->alertManager = $alertManager;
        $this->translator = $translator;
    }

    /**
     * Process site form.
     *
     * @param Request $request
     * @param FormInterface $form
     *
     * @return bool
     */
    public function process(Request $request, FormInterface $form)
    {
        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $this->siteManager->add($form->getData());

                return true;
            }
        }

        return false;
    }

    /**
     * On success.
     *
     * @param SiteInterface $site
     */
    public function onSuccess(SiteInterface $site)
    {
        $this->siteManager->save();

        $alert = $this->alertManager->create();

        $alert->addSuccess($this->translator->trans('success.site_save', array(), 'SilvestraSite'));
        $this->alertManager->setFlashAlert($alert);
    }
}
