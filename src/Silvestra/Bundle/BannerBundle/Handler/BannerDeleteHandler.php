<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\BannerBundle\Handler;

use Silvestra\Component\Banner\Model\BannerInterface;
use Silvestra\Component\Banner\Model\Manager\BannerManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/9/14 12:00 AM
 */
class BannerDeleteHandler
{

    /**
     * @var BannerManagerInterface
     */
    private $manager;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param BannerManagerInterface $manager
     * @param TranslatorInterface $translator
     */
    public function __construct(BannerManagerInterface $manager, TranslatorInterface $translator)
    {
        $this->manager = $manager;
        $this->translator = $translator;
    }

    /**
     * Process banner delete.
     *
     * @param BannerInterface $banner
     * @param Request $request
     *
     * @return bool
     */
    public function process($banner, Request $request)
    {
        if ($request->isMethod('DELETE')) {
            $this->manager->remove($banner);

            return true;
        }

        return false;
    }

    /**
     * On error.
     *
     * @return JsonResponse
     */
    public function onError()
    {
        return new JsonResponse(array(
            'title' => $this->translator->trans('an_error_occurred', array(), 'SilvestraBanner'),
            'type' => 'error'
        ));
    }

    /**
     * On success.
     *
     * @return JsonResponse
     */
    public function onSuccess()
    {
        return new JsonResponse(array(
            'title' => $this->translator->trans('success.delete_banner', array(), 'SilvestraBanner'),
            'type' => 'success'
        ));
    }
}
