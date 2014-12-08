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

use Silvestra\Component\Banner\Form\Type\BannerZoneType;
use Silvestra\Component\Banner\Model\BannerZone;
use Silvestra\Component\Banner\Provider\BannerZoneProviderInterface;
use Symfony\Component\Form\Forms;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/5/14 10:50 PM
 */
class BannerZoneTypeTest extends AbstractTypeTest
{
    /**
     * @var BannerZoneProviderInterface
     */
    private $zoneProvider;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->zoneProvider = $this->getMock('Silvestra\\Component\\Banner\\Provider\\BannerZoneProviderInterface');

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtension($this->createValidatorExtension())
            ->addTypeGuesser($this->getMockValidatorTypeGuesser())
            ->addTypes(
                array(
                    new BannerZoneType('Silvestra\\Component\\Banner\\Model\\BannerZone', $this->zoneProvider)
                )
            )
            ->getFormFactory();
        $this->builder = $this->createFormBuilder();
    }

    public function testEmptyFormType()
    {
        $form = $this->factory->create('silvestra_banner_zone');

        $this->assertEmpty($form->getData());
    }

    public function testFormType()
    {
        $this->zoneProvider
            ->expects($this->any())
            ->method('getConfigChoices')
            ->willReturn(array('silvestra' => 'Silvestra'));

        $bannerZone = new BannerZone();
        $form = $this->factory->create('silvestra_banner_zone', $bannerZone);

        $formData = array(
            'name' => 'Silvestra',
            'slug' => 'silvestra',
            'width' => 100,
            'height' => 200,
        );

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($bannerZone, $form->getData());
        $this->assertEquals($formData['name'], $bannerZone->getName());
        $this->assertEquals($formData['slug'], $bannerZone->getSlug());
        $this->assertEquals($formData['width'], $bannerZone->getWidth());
        $this->assertEquals($formData['height'], $bannerZone->getHeight());
    }
}
