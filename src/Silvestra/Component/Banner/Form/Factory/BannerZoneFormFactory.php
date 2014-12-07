<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Form\Factory;

use Silvestra\Component\Banner\Model\BannerZoneInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/5/14 11:41 PM
 */
class BannerZoneFormFactory
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * Create banner zone form.
     *
     * @param BannerZoneInterface $bannerZone
     *
     * @return FormInterface
     */
    public function create(BannerZoneInterface $bannerZone)
    {
        return $this->formFactory->create(
            'silvestra_banner_zone',
            $bannerZone,
            array('action' => $this->router->getContext()->getPathInfo())
        );
    }
}
