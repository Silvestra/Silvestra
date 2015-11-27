<?php

/*
 * This file is part of the Silvestra package.
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
    const FLASH_BAG_KEY = 'silvestra_notification_alerts';

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
        $this->flashBag->set(self::FLASH_BAG_KEY, $alert->all());
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
        return $this->flashBag->get(self::FLASH_BAG_KEY);
    }

    /**
     * Check for flash alerts.
     *
     * @return bool
     */
    public function hasFlashAlerts()
    {
        return 0 < count($this->flashBag->peek(self::FLASH_BAG_KEY));
    }
}
