<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\BannerBundle\Tests\Form\Type;

use Silvestra\Bundle\BannerBundle\Form\Type\BannerType;
use Silvestra\Bundle\MediaBundle\Form\DataTransformer\ImageTransformer;
use Silvestra\Bundle\MediaBundle\Form\Type\ImageType;
use Silvestra\Component\Banner\Model\Banner;
use Silvestra\Component\Locale\Helper\LocaleHelper;
use Silvestra\Component\Media\Image\Config\ImageDefaultConfig;
use Silvestra\Component\Media\Model\Image;
use Silvestra\Component\Media\Token\TokenGenerator;
use Symfony\Component\Form\Forms;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class BannerTypeTest extends AbstractTypeTest
{

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $localeHelper = $this->getMockBuilder(LocaleHelper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $localeHelper
            ->expects($this->any())
            ->method('getDisplayLocales')
            ->willReturn(array('en' => 'English'));

        $imageDefaultConfig = $this->getMockBuilder(ImageDefaultConfig::class)
            ->disableOriginalConstructor()
            ->getMock();
        $tokenGenerator = $this->getMockBuilder(TokenGenerator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $transformer = $this->getMockBuilder(ImageTransformer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtension($this->createValidatorExtension())
            ->addTypeGuesser($this->getMockValidatorTypeGuesser())
            ->addTypes(
                array(
                    new BannerType(Banner::class, $localeHelper),
                    new ImageType(
                        Image::class,
                        'silvestra.png',
                        $imageDefaultConfig,
                        $tokenGenerator,
                        $transformer
                    )
                )
            )
            ->getFormFactory();
        $this->builder = $this->createFormBuilder();
    }

    public function testEmptyFormType()
    {
//        $form = $this->factory->create('silvestra_banner');
//
//        $this->assertEmpty($form->getData());
    }
}
