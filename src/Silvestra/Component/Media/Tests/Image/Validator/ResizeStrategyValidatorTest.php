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

use Silvestra\Component\Media\Image\Validator\ResizeStrategyValidator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 8:19 PM
 */
class ResizeStrategyValidatorTest extends AbstractConfigValidator
{
    /**
     * @var ResizeStrategyValidator
     */
    private $validator;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->validator = new ResizeStrategyValidator();
    }

    public function testValidateMax()
    {
        $this->assertTrue($this->validator->validate('max', $this->getMockImageDefaultConfig()));
    }

    public function testValidateMin()
    {
        $this->assertTrue($this->validator->validate('min', $this->getMockImageDefaultConfig()));
    }

    public function testValidatePreview()
    {
        $this->assertTrue($this->validator->validate('preview', $this->getMockImageDefaultConfig()));
    }

    public function testValidateHeight()
    {
        $this->assertTrue($this->validator->validate('height', $this->getMockImageDefaultConfig()));
    }

    public function testValidateWidth()
    {
        $this->assertTrue($this->validator->validate('width', $this->getMockImageDefaultConfig()));
    }

    public function testValidateFake()
    {
        $this->assertFalse($this->validator->validate('fake', $this->getMockImageDefaultConfig()));
    }

    public function testConfigName()
    {
        $this->assertEquals('resize_strategy', $this->validator->getConfigName());
    }
}
