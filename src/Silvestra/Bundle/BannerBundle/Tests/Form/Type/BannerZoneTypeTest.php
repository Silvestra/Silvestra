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

use Silvestra\Bundle\BannerBundle\Form\Type\BannerZoneType;
use Silvestra\Component\Banner\Model\BannerZone;
use Symfony\Component\Form\Forms;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class BannerZoneTypeTest extends AbstractTypeTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtension($this->createValidatorExtension())
            ->addTypeGuesser($this->getMockValidatorTypeGuesser())
            ->addTypes(
                array(
                    new BannerZoneType(BannerZone::class)
                )
            )
            ->getFormFactory();
        $this->builder = $this->createFormBuilder();
    }

    public function testEmptyFormType()
    {
        $form = $this->factory->create(BannerZoneType::class);

        $this->assertEmpty($form->getData());
    }

    public function testFormType()
    {
        $bannerZone = new BannerZone();
        $form = $this->factory->create(BannerZoneType::class, $bannerZone);

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
