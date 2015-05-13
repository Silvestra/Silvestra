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
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Templating\EngineInterface;

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
    private $factory;

    /**
     * @var BannerFormHandler
     */
    private $handler;

    /**
     * @var BannerManagerInterface
     */
    private $manager;

    /**
     * @var BannerZoneManagerInterface
     */
    private $zoneManager;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * Constructor.
     *
     * @param BannerDeleteHandler $deleteHandler
     * @param EventDispatcherInterface $eventDispatcher
     * @param BannerFormFactory $factory
     * @param BannerFormHandler $handler
     * @param BannerManagerInterface $manager
     * @param BannerZoneManagerInterface $zoneManager
     * @param EngineInterface $templating
     */
    public function __construct(
        BannerDeleteHandler $deleteHandler,
        EventDispatcherInterface $eventDispatcher,
        BannerFormFactory $factory,
        BannerFormHandler $handler,
        BannerManagerInterface $manager,
        BannerZoneManagerInterface $zoneManager,
        EngineInterface $templating
    ) {
        $this->deleteHandler = $deleteHandler;
        $this->eventDispatcher = $eventDispatcher;
        $this->factory = $factory;
        $this->handler = $handler;
        $this->manager = $manager;
        $this->zoneManager = $zoneManager;
        $this->templating = $templating;
    }


    public function listAction($zoneId)
    {
        $bannerZone = $this->getBannerZone($zoneId);

        return $this->renderResponse(
            'SilvestraBannerBundle:Banner:list.html.twig',
            array(
                'banners' => $this->manager->findManyByZone($bannerZone),
                'banner_zone' => $bannerZone,
            )
        );
    }

    public function createAction(Request $request, $zoneId)
    {
        $bannerZone = $this->getBannerZone($zoneId);
        $banner = $this->manager->create();

        $banner->setZone($bannerZone);

        $form = $this->factory->create($banner);

        if ($this->handler->process($form, $request)) {
            $this->manager->save();
            $this->eventDispatcher->dispatch(BannerEvents::CREATE, $this->createEvent($banner, $request));

            return $this->handler->onSuccess($banner);
        }

        return $this->renderResponse(
            'SilvestraBannerBundle:Banner:create.html.twig',
            array('form' => $form->createView(), 'zone_id' => $zoneId)
        );
    }

    public function editAction(Request $request, $bannerId)
    {
        $banner = $this->manager->findById($bannerId);

        if (null === $banner) {
            throw new NotFoundHttpException();
        }

        $form = $this->factory->create($banner);

        if ($this->handler->process($form, $request)) {
            $this->manager->save();
            $this->eventDispatcher->dispatch(BannerEvents::EDIT, $this->createEvent($banner, $request));

            return $this->handler->onSuccess($banner);
        }

        return $this->renderResponse(
            'SilvestraBannerBundle:Banner:edit.html.twig',
            array('form' => $form->createView(), 'zone_id' => $banner->getZone()->getId())
        );
    }

    public function deleteAction(Request $request, $bannerId)
    {
        $banner = $this->manager->findById($bannerId);

        if ((null !== $banner)  && $this->deleteHandler->process($banner, $request)) {
            $this->manager->save();
            $this->eventDispatcher->dispatch(BannerEvents::DELETE, $this->createEvent($banner, $request));

            return $this->deleteHandler->onSuccess();
        }

        return $this->deleteHandler->onError();
    }

    /**
     * Get banner zone.
     *
     * @param integer $id
     *
     * @return BannerZoneInterface
     *
     * @throws NotFoundHttpException
     */
    private function getBannerZone($id)
    {
        $bannerZone = $this->zoneManager->findById($id);

        if (null === $bannerZone) {
            throw new NotFoundHttpException(sprintf('Not fount %s banner zone', $id));
        }

        return $bannerZone;
    }

    /**
     * Render response.
     *
     * @param string $name
     * @param array $parameters
     *
     * @return Response
     */
    private function renderResponse($name, array $parameters = array())
    {
        return new Response($this->templating->render($name, $parameters));
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
