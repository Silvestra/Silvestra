<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Seo\Tests\Form\Type;

use Silvestra\Component\Seo\Form\Type\SeoMetadataType;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Tadcka\Bundle\SandboxBundle\Entity\SeoMetadata;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/9/14 12:23 PM
 */
class SeoMetadataTypeTest extends TypeTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $validator = $this->getMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));

        $typeExtension = new FormTypeValidatorExtension($validator);

        $typeGuesser = $this->getMockBuilder('Symfony\\Component\\Form\\Extension\\Validator\\ValidatorTypeGuesser')
            ->disableOriginalConstructor()
            ->getMock();
        $types = array(
            new SeoMetadataType('Silvestra\\Component\\Seo\\Model\\SeoMetadata'),
        );

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtension($typeExtension)
            ->addTypeGuesser($typeGuesser)
            ->addTypes($types)
            ->getFormFactory();

        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }

    public function testEmptyFormType()
    {
        $form = $this->factory->create('silvestra_seo_metadata');

        $this->assertEmpty($form->getData());
    }

    public function testFormType()
    {
        $seoMetadata = new SeoMetadata();
        $form = $this->factory->create('silvestra_seo_metadata', $seoMetadata);

        $formData = array(
            'title' => 'Test title',
            'metaDescription' => 'Test meta description',
            'metaKeywords' => 'Test meta keywords',
        );

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($seoMetadata, $form->getData());
        $this->assertEquals('Test title', $seoMetadata->getTitle());
        $this->assertEquals('Test meta description', $seoMetadata->getMetaDescription());
        $this->assertEquals('Test meta keywords', $seoMetadata->getMetaKeywords());
    }
}
