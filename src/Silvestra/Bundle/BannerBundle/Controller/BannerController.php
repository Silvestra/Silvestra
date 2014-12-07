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

use Silvestra\Component\Banner\Form\Factory\BannerFormFactory;
use Silvestra\Component\Banner\Form\Handler\BannerFormHandler;
use Silvestra\Component\Banner\Model\BannerZoneInterface;
use Silvestra\Component\Banner\Model\Manager\BannerManagerInterface;
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
class BannerController
{
    /**
     * @var BannerManagerInterface
     */
    private $bannerManager;

    /**
     * @var BannerZoneManagerInterface
     */
    private $bannerZoneManager;

    /**
     * @var BannerFormFactory
     */
    private $factory;

    /**
     * @var BannerFormHandler
     */
    private $handler;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * Constructor.
     *
     * @param BannerManagerInterface $bannerManager
     * @param BannerZoneManagerInterface $bannerZoneManager
     * @param BannerFormFactory $factory
     * @param BannerFormHandler $handler
     * @param EngineInterface $templating
     */
    public function __construct(
        BannerManagerInterface $bannerManager,
        BannerZoneManagerInterface $bannerZoneManager,
        BannerFormFactory $factory,
        BannerFormHandler $handler,
        EngineInterface $templating
    ) {
        $this->bannerManager = $bannerManager;
        $this->bannerZoneManager = $bannerZoneManager;
        $this->factory = $factory;
        $this->handler = $handler;
        $this->templating = $templating;
    }


    public function listAction($zoneId)
    {
        $bannerZone = $this->getBannerZone($zoneId);

        return $this->renderResponse(
            'SilvestraBannerBundle:Banner:list.html.twig',
            array(
                'banners' => $this->bannerManager->findManyByZone($bannerZone),
                'banner_zone' => $bannerZone,
            )
        );
    }

    public function createAction(Request $request, $zoneId)
    {
        $bannerZone = $this->getBannerZone($zoneId);
        $banner = $this->bannerManager->create();

        $banner->setZone($bannerZone);

        $form = $this->factory->create($banner);

        if ($this->handler->process($form, $request)) {
            $this->bannerManager->save();

            return $this->handler->onSuccess($banner);
        }

        return $this->renderResponse(
            'SilvestraBannerBundle:Banner:create.html.twig',
            array('form' => $form->createView(), 'zone_id' => $zoneId)
        );
    }

    public function editAction(Request $request, $bannerId)
    {
        $banner = $this->bannerManager->findById($bannerId);

        if (null === $banner) {
            throw new NotFoundHttpException();
        }

        $form = $this->factory->create($banner);

        if ($this->handler->process($form, $request)) {
            $this->bannerManager->save();

            return $this->handler->onSuccess($banner);
        }

        return $this->renderResponse(
            'SilvestraBannerBundle:Banner:edit.html.twig',
            array('form' => $form->createView(), 'zone_id' => $banner->getZone()->getId())
        );
    }

    public function deleteAction(Request $request, $bannerId)
    {

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
        $bannerZone = $this->bannerZoneManager->findById($id);

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
}
