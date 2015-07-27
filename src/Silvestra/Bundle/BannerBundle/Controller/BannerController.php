<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\BannerBundle\Controller;

use Silvestra\Component\Banner\Event\BannerEvent;
use Silvestra\Component\Banner\Event\BannerEvents;
use Silvestra\Component\Banner\Form\Factory\BannerFormFactory;
use Silvestra\Component\Banner\Form\Handler\BannerFormHandler;
use Silvestra\Bundle\BannerBundle\Handler\BannerDeleteHandler;
use Silvestra\Component\Banner\Model\BannerInterface;
use Silvestra\Component\Banner\Model\BannerZoneInterface;
use Silvestra\Component\Banner\Model\Manager\BannerManagerInterface;
use Silvestra\Component\Banner\Model\Manager\BannerZoneManagerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/3/14 1:18 AM
 */
class BannerController
{

    /**
     * @var BannerDeleteHandler
     */
    private $deleteHandler;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var BannerFormFactory
     */
    private $formFactory;

    /**
     * @var BannerFormHandler
     */
    private $formHandler;

    /**
     * @var BannerManagerInterface
     */
    private $bannerManager;

    /**
     * @var BannerZoneManagerInterface
     */
    private $bannerZoneManager;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * Constructor.
     *
     * @param BannerDeleteHandler $deleteHandler
     * @param EventDispatcherInterface $eventDispatcher
     * @param BannerFormFactory $formFactory
     * @param BannerFormHandler $formHandler
     * @param BannerManagerInterface $bannerManager
     * @param BannerZoneManagerInterface $bannerZoneManager
     * @param EngineInterface $templating
     */
    public function __construct(
        BannerDeleteHandler $deleteHandler,
        EventDispatcherInterface $eventDispatcher,
        BannerFormFactory $formFactory,
        BannerFormHandler $formHandler,
        BannerManagerInterface $bannerManager,
        BannerZoneManagerInterface $bannerZoneManager,
        EngineInterface $templating
    ) {
        $this->deleteHandler = $deleteHandler;
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
        $this->bannerManager = $bannerManager;
        $this->bannerZoneManager = $bannerZoneManager;
        $this->templating = $templating;
    }


    public function listAction($zoneId)
    {
        $bannerZone = $this->getBannerZoneOr404($zoneId);

        return $this->templating->renderResponse(
            'SilvestraBannerBundle:Banner:list.html.twig',
            array(
                'banners' => $this->bannerManager->findManyByZone($bannerZone),
                'banner_zone' => $bannerZone,
            )
        );
    }

    public function createAction(Request $request, $zoneId)
    {
        $bannerZone = $this->getBannerZoneOr404($zoneId);
        $banner = $this->bannerManager->create();

        $banner->setZone($bannerZone);

        $form = $this->formFactory->create($banner);

        if ($this->formHandler->process($form, $request)) {
            $this->bannerManager->save();
            $this->eventDispatcher->dispatch(BannerEvents::CREATE, $this->createEvent($banner, $request));

            return $this->formHandler->onSuccess($banner);
        }

        return $this->templating->renderResponse(
            'SilvestraBannerBundle:Banner:create.html.twig',
            array(
                'form' => $form->createView(),
                'zone_id' => $zoneId
            )
        );
    }

    public function editAction(Request $request, $bannerId)
    {
        $banner = $this->getBannerOr404($bannerId);
        $form = $this->formFactory->create($banner);

        if ($this->formHandler->process($form, $request)) {
            $this->bannerManager->save();
            $this->eventDispatcher->dispatch(BannerEvents::EDIT, $this->createEvent($banner, $request));

            return $this->formHandler->onSuccess($banner);
        }

        return $this->templating->renderResponse(
            'SilvestraBannerBundle:Banner:edit.html.twig',
            array(
                'form' => $form->createView(),
                'zone_id' => $banner->getZone()->getId()
            )
        );
    }

    public function deleteAction(Request $request, $bannerId)
    {
        $banner = $this->getBannerOr404($bannerId);

        if ($this->deleteHandler->process($banner, $request)) {
            $this->bannerManager->save();
            $this->eventDispatcher->dispatch(BannerEvents::DELETE, $this->createEvent($banner, $request));

            return $this->deleteHandler->onSuccess();
        }

        return $this->deleteHandler->onError();
    }

    /**
     * Get banner zone or 404.
     *
     * @param int $bannerZoneId
     *
     * @return BannerZoneInterface
     *
     * @throws NotFoundHttpException
     */
    private function getBannerZoneOr404($bannerZoneId)
    {
        $bannerZone = $this->bannerZoneManager->findById($bannerZoneId);

        if (null === $bannerZone) {
            throw new NotFoundHttpException(sprintf('Not found %s banner zone', $bannerZoneId));
        }

        return $bannerZone;
    }

    /**
     * Get banner or 404.
     *
     * @param int $bannerId
     *
     * @return BannerInterface
     *
     * @throws NotFoundHttpException
     */
    private function getBannerOr404($bannerId)
    {
        $banner = $this->bannerManager->findById($bannerId);

        if (null === $banner) {
            throw new NotFoundHttpException(sprintf('Not found %s banner', $bannerId));
        }

        return $banner;
    }

    /**
     * Create banner event.
     *
     * @param BannerInterface $banner
     * @param Request $request
     *
     * @return BannerEvent
     */
    private function createEvent($banner, Request $request)
    {
        return new BannerEvent($banner, $request->getLocale());
    }
}
