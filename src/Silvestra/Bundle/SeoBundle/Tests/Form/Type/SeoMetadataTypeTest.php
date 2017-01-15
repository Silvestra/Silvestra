<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SeoBundle\Tests\Form\Type;

use Silvestra\Bundle\FormBundle\Form\Type\KeyValueRowType;
use Silvestra\Bundle\FormBundle\Form\Type\KeyValueType;
use Silvestra\Bundle\FormBundle\Form\Type\TagType;
use Silvestra\Bundle\SeoBundle\Form\Type\SeoMetadataType;
use Silvestra\Component\Seo\Model\SeoMetadata;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

        $validator = $this->getMock(ValidatorInterface::class);
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));

        $typeExtension = new FormTypeValidatorExtension($validator);

        $typeGuesser = $this->getMockBuilder(ValidatorTypeGuesser::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtension($typeExtension)
            ->addTypeGuesser($typeGuesser)
            ->addTypes(array(
                new KeyValueRowType(),
                new KeyValueType(),
                new TagType(),
                new SeoMetadataType(SeoMetadata::class)
            ))
            ->getFormFactory();

        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }

    public function testEmptyFormType()
    {
        $form = $this->factory->create(SeoMetadataType::class);

        $this->assertEmpty($form->getData());
    }

    public function testFormType()
    {
        $seoMetadata = new SeoMetadata();
        $form = $this->factory->create(SeoMetadataType::class, $seoMetadata);

        $formData = array(
            'title' => 'Test title',
            'metaDescription' => 'Test meta description',
            'metaKeywords' => array('tags' => array('Test meta keywords')),
        );

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($seoMetadata, $form->getData());
        $this->assertEquals('Test title', $seoMetadata->getTitle());
        $this->assertEquals('Test meta description', $seoMetadata->getMetaDescription());
        $this->assertEquals('Test meta keywords', $seoMetadata->getMetaKeywords());
    }
}
