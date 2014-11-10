<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Form\Tests\Type;

use Silvestra\Component\Form\Type\TagType;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/10/14 10:18 PM
 */
class TagTypeTest extends TypeTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $validator = $this->getMock('Symfony\\Component\\Validator\\Validator\\ValidatorInterface');
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));

        $typeExtension = new FormTypeValidatorExtension($validator);

        $typeGuesser = $this->getMockBuilder('Symfony\\Component\\Form\\Extension\\Validator\\ValidatorTypeGuesser')
            ->disableOriginalConstructor()
            ->getMock();
        $types = array(new TagType());

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtension($typeExtension)
            ->addTypeGuesser($typeGuesser)
            ->addTypes($types)
            ->getFormFactory();

        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }

    public function testEmptyFormType()
    {
        $form = $this->factory->create('silvestra_tag');

        $this->assertEmpty($form->getData());
    }

    public function testFormType()
    {
        $form = $this->factory->create('silvestra_tag');

        $formData = array('tags' => array('Test', 'Silvestra Test'));

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals('Test, Silvestra Test', $form->getData());
    }
}
