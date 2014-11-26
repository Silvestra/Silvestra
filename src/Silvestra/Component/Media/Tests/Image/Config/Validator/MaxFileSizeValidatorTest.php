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

use Silvestra\Component\Media\Image\Config\Validator\MaxFileSizeValidator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 8:17 PM
 */
class MaxFileSizeValidatorTest extends AbstractConfigValidator
{
    /**
     * @var MaxFileSizeValidator
     */
    private $validator;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->validator = new MaxFileSizeValidator();
    }

    public function testValidateWithValidData()
    {
        $defaultConfig = $this->getMockImageDefaultConfig();

        $defaultConfig->expects($this->any())
            ->method('getMaxFileSize')
            ->willReturn(5);

        $this->assertTrue($this->validator->validate(5, $defaultConfig));
    }

    public function testValidateWithNotValidData()
    {
        $defaultConfig = $this->getMockImageDefaultConfig();

        $defaultConfig->expects($this->any())
            ->method('getMaxFileSize')
            ->willReturn(4);

        $this->assertFalse($this->validator->validate(5, $defaultConfig));
    }

    public function testConfigName()
    {
        $this->assertEquals('max_file_size', $this->validator->getConfigName());
    }
}
