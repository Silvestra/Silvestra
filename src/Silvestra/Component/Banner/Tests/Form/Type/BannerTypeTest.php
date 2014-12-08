<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Banner\Tests\Form\Type;

use Silvestra\Component\Banner\Form\Type\BannerType;
use Silvestra\Component\Media\Form\Type\ImageType;
use Symfony\Component\Form\Forms;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/5/14 10:50 PM
 */
class BannerTypeTest extends AbstractTypeTest
{

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $localeHelper = $this->getMockBuilder('Silvestra\\Component\\Locale\\Helper\\LocaleHelper')
            ->disableOriginalConstructor()
            ->getMock();
        $localeHelper
            ->expects($this->any())
            ->method('getDisplayLocales')
            ->willReturn(array('en' => 'English'));

        $imageDefaultConfig = $this->getMockBuilder('Silvestra\\Component\\Media\\Image\\Config\\ImageDefaultConfig')
            ->disableOriginalConstructor()
            ->getMock();
        $tokenGenerator = $this->getMockBuilder('Silvestra\\Component\\Media\\Token\\TokenGenerator')
            ->disableOriginalConstructor()
            ->getMock();
        $transformer = $this->getMockBuilder('Silvestra\\Component\\Media\\Form\\DataTransformer\\ImageTransformer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtension($this->createValidatorExtension())
            ->addTypeGuesser($this->getMockValidatorTypeGuesser())
            ->addTypes(
                array(
                    new BannerType('Silvestra\\Component\\Banner\\Model\\Banner', $localeHelper),
                    new ImageType(
                        'Silvestra\\Component\\Media\\Model\\Image',
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
