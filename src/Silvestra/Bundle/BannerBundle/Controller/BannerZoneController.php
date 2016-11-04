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

use Silvestra\Component\Banner\BannerZoneSynchronizer;
use Silvestra\Component\Banner\Event\BannerZoneEvent;
use Silvestra\Component\Banner\Event\BannerZoneEvents;
use Silvestra\Component\Banner\Form\Factory\BannerZoneFormFactory;
use Silvestra\Component\Banner\Form\Handler\BannerZoneFormHandler;
use Silvestra\Bundle\BannerBundle\Handler\BannerZoneDeleteHandler;
use Silvestra\Component\Banner\Model\BannerZoneInterface;
use Silvestra\Component\Banner\Model\Manager\BannerZoneManagerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/3/14 1:18 AM
 */
class BannerZoneController
{

    /**
     * @var BannerZoneDeleteHandler
     */
    private $deleteHandler;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var BannerZoneFormFactory
     */
    private $formFactory;

    /**
     * @var BannerZoneFormHandler
     */
    private $formHandler;

    /**
     * @var BannerZoneManagerInterface
     */
    private $bannerZoneManager;

    /**
     * @var BannerZoneSynchronizer
     */
    private $synchronizer;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * Constructor.
     *
     * @param BannerZoneDeleteHandler $deleteHandler
     * @param EventDispatcherInterface $eventDispatcher
     * @param BannerZoneFormFactory $formFactory
     * @param BannerZoneFormHandler $formHandler
     * @param BannerZoneManagerInterface $bannerZoneManager
     * @param BannerZoneSynchronizer $synchronizer
     * @param EngineInterface $templating
     */
    public function __construct(
        BannerZoneDeleteHandler $deleteHandler,
        EventDispatcherInterface $eventDispatcher,
        BannerZoneFormFactory $formFactory,
        BannerZoneFormHandler $formHandler,
        BannerZoneManagerInterface $bannerZoneManager,
        BannerZoneSynchronizer $synchronizer,
        EngineInterface $templating
    ) {
        $this->deleteHandler = $deleteHandler;
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
        $this->bannerZoneManager = $bannerZoneManager;
        $this->synchronizer = $synchronizer;
        $this->templating = $templating;
    }

    public function listAction(Request $request)
    {
        $this->synchronizer->synchronize($request->getLocale());

        return $this->templating->renderResponse(
            'SilvestraBannerBundle:BannerZone:list.html.twig',
            array(
                'banner_zones' => $this->bannerZoneManager->findAll()
            )
        );
    }

    public function createAction(Request $request)
    {
        $bannerZone = $this->bannerZoneManager->create();
        $form = $this->formFactory->create($bannerZone);

        if ($this->formHandler->process($form, $request)) {
            $this->bannerZoneManager->save();
            $this->eventDispatcher->dispatch(BannerZoneEvents::CREATE, $this->createEvent($bannerZone, $request));

            return $this->formHandler->onSuccess();
        }

        return $this->templating->renderResponse(
            'SilvestraBannerBundle:BannerZone:create.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function editAction(Request $request, $zoneId)
    {
        $bannerZone = $this->getBannerZoneOr404($zoneId);
        $form = $this->formFactory->create($bannerZone);

        if ($this->formHandler->process($form, $request)) {
            $this->bannerZoneManager->save();
            $this->eventDispatcher->dispatch(BannerZoneEvents::EDIT, $this->createEvent($bannerZone, $request));

            return $this->formHandler->onSuccess();
        }

        return $this->templating->renderResponse(
            'SilvestraBannerBundle:BannerZone:edit.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function deleteAction(Request $request, $zoneId)
    {
        $bannerZone = $this->getBannerZoneOr404($zoneId);

        if ($this->deleteHandler->process($bannerZone, $request)) {
            $this->bannerZoneManager->save();
            $this->eventDispatcher->dispatch(BannerZoneEvents::DELETE, $this->createEvent($bannerZone, $request));

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
     * Create banner zone event.
     *
     * @param BannerZoneInterface $bannerZone
     * @param Request $request
     *
     * @return BannerZoneEvent
     */
    private function createEvent($bannerZone, Request $request)
    {
        return new BannerZoneEvent($bannerZone, $request->getLocale());
    }
}
