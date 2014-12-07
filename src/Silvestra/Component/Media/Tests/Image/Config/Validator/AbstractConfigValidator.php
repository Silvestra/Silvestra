<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Tests\Image\Config\Validator;

use Silvestra\Component\Media\Image\Config\ImageDefaultConfig;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 8:25 PM
 */
class AbstractConfigValidator extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ImageDefaultConfig
     */
    protected function getMockImageDefaultConfig()
    {
        return $this->getMockBuilder('Silvestra\\Component\\Media\\Image\\Config\\ImageDefaultConfig')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
