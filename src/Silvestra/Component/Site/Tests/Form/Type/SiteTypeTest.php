<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Site\Tests\Form\Type;

use Silvestra\Component\Site\Form\Type\SiteType;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/10/14 11:05 PM
 */
class SiteTypeTest extends TypeTestCase
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
        $types = array(new SiteType('Silvestra\\Component\\Site\\Model\\Site'));

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtension($typeExtension)
            ->addTypeGuesser($typeGuesser)
            ->addTypes($types)
            ->getFormFactory();

        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }

    public function testEmptyFormType()
    {
//        $form = $this->factory->create('silvestra_site');
//
//        $this->assertEmpty($form->getData());
    }
}
