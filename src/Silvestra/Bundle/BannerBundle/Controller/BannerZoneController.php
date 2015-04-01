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
    private $factory;

    /**
     * @var BannerZoneFormHandler
     */
    private $handler;

    /**
     * @var BannerZoneManagerInterface
     */
    private $manager;

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
     * @param BannerZoneFormFactory $factory
     * @param BannerZoneFormHandler $handler
     * @param BannerZoneManagerInterface $manager
     * @param BannerZoneSynchronizer $synchronizer
     * @param EngineInterface $templating
     */
    public function __construct(
        BannerZoneDeleteHandler $deleteHandler,
        EventDispatcherInterface $eventDispatcher,
        BannerZoneFormFactory $factory,
        BannerZoneFormHandler $handler,
        BannerZoneManagerInterface $manager,
        BannerZoneSynchronizer $synchronizer,
        EngineInterface $templating
    ) {
        $this->deleteHandler = $deleteHandler;
        $this->eventDispatcher = $eventDispatcher;
        $this->factory = $factory;
        $this->handler = $handler;
        $this->manager = $manager;
        $this->synchronizer = $synchronizer;
        $this->templating = $templating;
    }

    public function listAction(Request $request)
    {
        $this->synchronizer->synchronize($request->getLocale());

        return $this->renderResponse(
            'SilvestraBannerBundle:BannerZone:list.html.twig',
            array('banner_zones' => $this->manager->findAll())
        );
    }

    public function createAction(Request $request)
    {
        $bannerZone = $this->manager->create();
        $form = $this->factory->create($bannerZone);

        if ($this->handler->process($form, $request)) {
            $this->manager->save();
            $this->eventDispatcher->dispatch(BannerZoneEvents::CREATE, $this->createEvent($bannerZone, $request));

            return $this->handler->onSuccess();
        }

        return $this->renderResponse(
            'SilvestraBannerBundle:BannerZone:create.html.twig',
            array('form' => $form->createView())
        );
    }

    public function editAction(Request $request, $zoneId)
    {
        $bannerZone = $this->manager->findById($zoneId);

        if (null === $bannerZone) {
            throw new NotFoundHttpException(sprintf('Not found %s banner zone!', $zoneId));
        }

        $form = $this->factory->create($bannerZone);

        if ($this->handler->process($form, $request)) {
            $this->manager->save();
            $this->eventDispatcher->dispatch(BannerZoneEvents::EDIT, $this->createEvent($bannerZone, $request));

            return $this->handler->onSuccess();
        }

        return $this->renderResponse(
            'SilvestraBannerBundle:BannerZone:edit.html.twig',
            array('form' => $form->createView())
        );
    }

    public function deleteAction(Request $request, $zoneId)
    {
        $bannerZone = $this->manager->findById($zoneId);

        if ($this->deleteHandler->process($bannerZone, $request)) {
            $this->manager->save();
            $this->eventDispatcher->dispatch(BannerZoneEvents::DELETE, $this->createEvent($bannerZone, $request));

            return $this->deleteHandler->onSuccess();
        }

        return $this->deleteHandler->onError();
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
