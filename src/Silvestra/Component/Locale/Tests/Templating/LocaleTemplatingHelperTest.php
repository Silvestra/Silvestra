<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Locale\Tests\Templating;

use Silvestra\Component\Locale\Templating\LocaleTemplatingHelper;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/7/14 10:47 PM
 */
class LocaleTemplatingHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LocaleTemplatingHelper
     */
    private $helper;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->helper = new LocaleTemplatingHelper();
    }

    public function testGetLocaleDisplayName()
    {
        $this->assertEquals('English', $this->helper->getLocaleDisplayName('en'));
        $this->assertEquals('Lithuanian', $this->helper->getLocaleDisplayName('lt'));
    }
}
 