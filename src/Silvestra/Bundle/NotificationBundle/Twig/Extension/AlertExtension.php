<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\NotificationBundle\Twig\Extension;

use Silvestra\Component\Notification\AlertManager;
use Silvestra\Component\Notification\Templating\AlertHelperInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/8/14 1:00 PM
 */
class AlertExtension extends \Twig_Extension
{
    /**
     * @var AlertHelperInterface
     */
    private $alertHelper;

    /**
     * @var AlertManager
     */
    private $alertManager;

    /**
     * @var string
     */
    private $alertTemplate;

    /**
     * Constructor.
     *
     * @param AlertHelperInterface $alertHelper
     * @param AlertManager $alertManager
     * @param string $alertTemplate
     */
    public function __construct(AlertHelperInterface $alertHelper, AlertManager $alertManager, $alertTemplate)
    {
        $this->alertHelper = $alertHelper;
        $this->alertManager = $alertManager;
        $this->alertTemplate = $alertTemplate;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'silvestra_alerts_render',
                array($this, 'render'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFunction(
                'silvestra_flash_alerts_render',
                array($this, 'renderFlash'),
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     * Render alerts template.
     *
     * @param array $options
     *
     * @return string
     */
    public function render($options = array())
    {
        $alert = $this->alertManager->getAlert();
        $options['alerts'] = $alert ? $alert->all() : array();

        return $this->alertHelper->render($this->getTemplate($options), $options);
    }

    /**
     * Render flash alerts template.
     *
     * @param array $options
     *
     * @return string
     */
    public function renderFlash($options = array())
    {
        $options['alerts'] = $this->alertManager->getFlashAlerts();

        return $this->alertHelper->render($this->getTemplate($options), $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'silvestra_alert';
    }

    /**
     * Get template.
     *
     * @param array $options
     *
     * @return string
     */
    private function getTemplate(array $options)
    {
        if (isset($options['template'])) {
            return $options['template'];
        }

        return $this->alertTemplate;
    }
}
