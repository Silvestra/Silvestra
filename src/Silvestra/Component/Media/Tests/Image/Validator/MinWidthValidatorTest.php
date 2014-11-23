<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Tests\Image\Validator;

use Silvestra\Component\Media\Image\Validator\MinWidthValidator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 8:18 PM
 */
class MinWidthValidatorTest extends AbstractConfigValidator
{
    /**
     * @var MinWidthValidator
     */
    private $validator;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->validator = new MinWidthValidator();
    }

    public function testValidateWithValidData()
    {
        $defaultConfig = $this->getMockImageDefaultConfig();

        $defaultConfig->expects($this->any())
            ->method('getMinWidth')
            ->willReturn(400);

        $this->assertTrue($this->validator->validate(500, $defaultConfig));
    }

    public function testValidateWithNotValidData()
    {
        $defaultConfig = $this->getMockImageDefaultConfig();

        $defaultConfig->expects($this->any())
            ->method('getMinWidth')
            ->willReturn(400);

        $this->assertFalse($this->validator->validate(300, $defaultConfig));
    }

    public function testConfigName()
    {
        $this->assertEquals('min_width', $this->validator->getConfigName());
    }
}
