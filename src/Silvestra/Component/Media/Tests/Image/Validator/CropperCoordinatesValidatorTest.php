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

use Silvestra\Component\Media\Image\Validator\CropperCoordinatesValidator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 8:16 PM
 */
class CropperCoordinatesValidatorTest extends AbstractConfigValidator
{
    /**
     * @var CropperCoordinatesValidator
     */
    private $validator;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->validator = new CropperCoordinatesValidator();
    }

    public function testValidate()
    {
        $mock = $this->getMockImageDefaultConfig();

        $this->assertFalse($this->validator->validate(array(), $mock));
        $this->assertTrue($this->validator->validate(array(1, 2, 3, 4), $mock));
    }

    public function testValidateWithInvalidArgument()
    {
        $this->setExpectedException('Silvestra\\Component\\Media\\Exception\\InvalidArgumentException');

        $this->assertTrue($this->validator->validate(null, $this->getMockImageDefaultConfig()));
    }

    public function testConfigName()
    {
        $this->assertEquals('cropper_coordinates', $this->validator->getConfigName());
    }
}
