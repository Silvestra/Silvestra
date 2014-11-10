<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Notification\Tests;

use Silvestra\Component\Notification\Alert;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/8/14 12:11 PM
 */
class AlertTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Alert
     */
    private $alert;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->alert = new Alert();
    }

    /**
     * Test method: getDangerAlerts().
     */
    public function testDanger()
    {
        $this->alert->addDanger('danger_1');
        $this->alert->addDanger('danger_2');

        $alerts = $this->alert->getDangerAlerts();

        $this->assertCount(2, $alerts);
        $this->assertEquals('danger_1', $alerts[0]);
        $this->assertEquals('danger_2', $alerts[1]);
    }

    /**
     * Test method: getInfoAlerts().
     */
    public function testInfo()
    {
        $this->alert->addInfo('info_1');
        $this->alert->addInfo('info_2');

        $alerts = $this->alert->getInfoAlerts();

        $this->assertCount(2, $alerts);
        $this->assertEquals('info_1', $alerts[0]);
        $this->assertEquals('info_2', $alerts[1]);
    }

    /**
     * Test method: getSuccessAlerts().
     */
    public function testSuccess()
    {
        $this->alert->addSuccess('success_1');
        $this->alert->addSuccess('success_2');

        $alerts = $this->alert->getSuccessAlerts();

        $this->assertCount(2, $alerts);
        $this->assertEquals('success_1', $alerts[0]);
        $this->assertEquals('success_2', $alerts[1]);
    }

    /**
     * Test method: getWaringAlerts().
     */
    public function testWarning()
    {
        $this->alert->addWarning('warning_1');
        $this->alert->addWarning('warning_2');

        $alerts = $this->alert->getWaringAlerts();

        $this->assertCount(2, $alerts);
        $this->assertEquals('warning_1', $alerts[0]);
        $this->assertEquals('warning_2', $alerts[1]);
    }
}
