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

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/8/14 11:57 AM
 */
class Alert
{
    /**
     * Danger alert.
     */
    const DANGER = 'danger';

    /**
     * Info alert.
     */
    const INFO = 'info';

    /**
     * Success alert.
     */
    const SUCCESS = 'success';

    /**
     * warning alert.
     */
    const WARNING = 'warning';

    /**
     * @var array
     */
    private $alerts = array();

    public function addAlert($alert, $type)
    {
        $this->alerts[$type][] = $alert;
    }

    /**
     * Add danger.
     *
     * @param string $alert
     */
    public function addDanger($alert)
    {
        $this->addAlert($alert, self::DANGER);
    }

    /**
     * Add info.
     *
     * @param string $alert
     */
    public function addInfo($alert)
    {
        $this->addAlert($alert, self::INFO);
    }

    /**
     * Add success.
     *
     * @param string $alert
     */
    public function addSuccess($alert)
    {
        $this->addAlert($alert, self::SUCCESS);
    }

    /**
     * Add warning.
     *
     * @param string $alert
     */
    public function addWarning($alert)
    {
        $this->addAlert($alert, self::WARNING);
    }

    /**
     * Get alert by type.
     *
     * @param string $type
     *
     * @return array
     */
    public function getAlert($type)
    {
        return $this->hasAlert($type) ? $this->alerts[$type] : array();
    }

    /**
     * Get all alerts.
     *
     * @return array
     */
    public function all()
    {
        return $this->alerts;
    }

    /**
     * Get danger alerts.
     *
     * @return array
     */
    public function getDangerAlerts()
    {
        return $this->getAlert(self::DANGER);
    }

    /**
     * Get info alerts.
     *
     * @return array
     */
    public function getInfoAlerts()
    {
        return $this->getAlert(self::INFO);
    }

    /**
     * Get success alerts.
     *
     * @return array
     */
    public function getSuccessAlerts()
    {
        return $this->getAlert(self::SUCCESS);
    }

    /**
     * Get warning alerts.
     *
     * @return array
     */
    public function getWaringAlerts()
    {
        return $this->getAlert(self::WARNING);
    }

    /**
     * Check if has alert by type.
     *
     * @param string $type
     *
     * @return bool
     */
    private function hasAlert($type)
    {
        return isset($this->alerts[$type]);
    }
}
