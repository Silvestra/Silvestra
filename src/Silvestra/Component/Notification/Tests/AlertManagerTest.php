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

use Silvestra\Component\Notification\AlertManager;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/8/14 12:23 PM
 */
class AlertManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AlertManager
     */
    private $alertManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->alertManager = new AlertManager($this->createSessionMock());
    }

    /**
     * Test method: create() alert.
     */
    public function testCreate()
    {
        $this->assertInstanceOf('Silvestra\\Component\\Notification\\Alert', $this->alertManager->create());
    }

    /**
     * Test method: setAlert().
     */
    public function testSetAlert()
    {
        $alert = $this->alertManager->create();

        $this->alertManager->setAlert($alert);

        $this->assertEquals($alert, $this->alertManager->getAlert());
    }

    /**
     * Test method: setFlashAlert().
     */
    public function testSetFlashAlert()
    {
        $alert = $this->alertManager->create();
        $alert->addSuccess('success');

        $this->alertManager->setFlashAlert($alert);

        $this->assertEquals($alert->all(), $this->alertManager->getFlashAlerts());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Session
     */
    private function createSessionMock()
    {
        $session = $this->getMock(Session::class);

        $session
            ->method('getFlashBag')
            ->willReturn(new FlashBag());

        return $session;
    }
}
