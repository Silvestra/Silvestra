<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Tests\Image;

use Silvestra\Component\Media\Image\Config\ImageDefaultConfig;
use Silvestra\Component\Media\Image\ImageValidator;
use Silvestra\Component\Media\Image\Config\Validator\MaxFileSizeValidator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/23/14 8:47 PM
 */
class ImageValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ImageValidator
     */
    private $validator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ImageDefaultConfig
     */
    private $defaultConfig;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->defaultConfig = $this->getMockBuilder('Silvestra\\Component\\Media\\Image\\Config\\ImageDefaultConfig')
            ->disableOriginalConstructor()
            ->getMock();

        $this->validator = new ImageValidator($this->defaultConfig);
    }

    public function testConfigIsValid()
    {
        $config = array('max_file_size' => 5);
        $this->validator->addConfigValidator(new MaxFileSizeValidator());

        $this->assertFalse($this->validator->configIsValid($config));

        $this->defaultConfig->expects($this->any())
            ->method('getMaxFileSize')
            ->willReturn(5);

        $this->assertTrue($this->validator->configIsValid($config));
    }

    public function testConfigIsValidException()
    {
        $this->setExpectedException('Silvestra\\Component\\Media\\Exception\\InvalidImageConfigException');

        $this->validator->addConfigValidator(new MaxFileSizeValidator());
        $this->validator->configIsValid(array());
    }
}
