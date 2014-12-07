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

use Silvestra\Component\Banner\Form\Factory\BannerZoneFormFactory;
use Silvestra\Component\Banner\Form\Handler\BannerZoneFormHandler;
use Silvestra\Component\Banner\Model\Manager\BannerZoneManagerInterface;
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
     * @var EngineInterface
     */
    private $templating;

    /**
     * Constructor.
     *
     * @param BannerZoneFormFactory $factory
     * @param BannerZoneFormHandler $handler
     * @param BannerZoneManagerInterface $manager
     * @param EngineInterface $templating
     */
    public function __construct(
        BannerZoneFormFactory $factory,
        BannerZoneFormHandler $handler,
        BannerZoneManagerInterface $manager,
        EngineInterface $templating
    ) {
        $this->factory = $factory;
        $this->handler = $handler;
        $this->manager = $manager;
        $this->templating = $templating;
    }

    public function listAction()
    {
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

            return $this->handler->onSuccess();
        }

        return $this->renderResponse(
            'SilvestraBannerBundle:BannerZone:edit.html.twig',
            array('form' => $form->createView())
        );
    }

    public function deleteAction(Request $request, $zoneId)
    {

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
}
