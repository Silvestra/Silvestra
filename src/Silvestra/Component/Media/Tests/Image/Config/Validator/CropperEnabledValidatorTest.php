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

use Silvestra\Component\Media\Image\Config\Validator\CropperEnabledValidator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 8:17 PM
 */
class CropperEnabledValidatorTest extends AbstractConfigValidator
{
    /**
     * @var CropperEnabledValidator
     */
    private $validator;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->validator = new CropperEnabledValidator();
    }

    public function testValidate()
    {
        $this->assertTrue($this->validator->validate(true, $this->getMockImageDefaultConfig()));
    }

    public function testConfigName()
    {
        $this->assertEquals('cropper_enabled', $this->validator->getConfigName());
    }
}
