<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SiteBundle\EventListener;

use Silvestra\Bundle\AdminBundle\Event\AdminMenuEvent;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/28/14 10:46 PM
 */
class AdminMenuListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param AdminMenuEvent $event
     */
    public function onAdminMenu(AdminMenuEvent $event)
    {
        $tradedoublerMapper = $event->getMenu()->addChild(
            $this->translator->trans('site', array(), 'SilvestraSiteBundle'),
            array('route' => 'silvestra_site')
        );
        $tradedoublerMapper->setLabelAttribute('menu_logo', 'fa-globe');
    }
}
