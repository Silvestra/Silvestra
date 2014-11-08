<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Notification;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/8/14 12:19 PM
 */
class AlertManager
{
    /**
     * @var Alert
     */
    private $alert;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * Constructor.
     *
     * @param FlashBagInterface $flashBag
     */
    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    /**
     * Set alert.
     *
     * @param Alert $alert
     */
    public function setAlert(Alert $alert)
    {
        $this->alert = $alert;
    }

    /**
     * Set flash alert.
     *
     * @param Alert $alert
     */
    public function setFlashAlert(Alert $alert)
    {
        $this->flashBag->set('silvestra_notification_alerts', $alert->all());
    }

    /**
     * Create alert.
     *
     * @return Alert
     */
    public function create()
    {
        return new Alert();
    }

    /**
     * Get alert.
     *
     * @return Alert
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * Get flash alerts.
     *
     * @return array
     */
    public function getFlashAlerts()
    {
        return $this->flashBag->get('silvestra_notification_alerts');
    }
}
