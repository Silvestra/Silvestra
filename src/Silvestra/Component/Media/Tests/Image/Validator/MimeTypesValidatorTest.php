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

use Silvestra\Component\Media\Image\Validator\MimeTypesValidator;
use Silvestra\Component\Media\Media;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 8:18 PM
 */
class MimeTypesValidatorTest extends AbstractConfigValidator
{
    /**
     * @var MimeTypesValidator
     */
    private $validator;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->validator = new MimeTypesValidator();
    }

    public function testValidateWithValidData()
    {
        $defaultConfig = $this->getMockImageDefaultConfig();

        $defaultConfig->expects($this->any())
            ->method('getAvailableMimeTypes')
            ->willReturn(Media::getImageMimeTypes());

        $this->assertTrue($this->validator->validate(array('image/png', 'image/jpeg'), $defaultConfig));
    }

    public function testValidateWithNotValidData()
    {
        $defaultConfig = $this->getMockImageDefaultConfig();

        $defaultConfig->expects($this->any())
            ->method('getAvailableMimeTypes')
            ->willReturn(Media::getImageMimeTypes());

        $this->assertFalse($this->validator->validate(array('text/html'), $defaultConfig));
    }

    public function testValidateWithInvalidArgument()
    {
        $this->setExpectedException('Silvestra\\Component\\Media\\Exception\\InvalidArgumentException');

        $this->assertTrue($this->validator->validate('text/html', $this->getMockImageDefaultConfig()));
    }

    public function testConfigName()
    {
        $this->assertEquals('mime_types', $this->validator->getConfigName());
    }
}
