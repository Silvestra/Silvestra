<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\SiteBundle\Tests\Form\Type;

use Silvestra\Bundle\SiteBundle\Form\Type\SiteType;
use Silvestra\Component\Site\Model\Site;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class SiteTypeTest extends TypeTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $validator = $this->getMock(ValidatorInterface::class);
        $validator
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList()));

        $typeExtension = new FormTypeValidatorExtension($validator);

        $typeGuesser = $this->getMockBuilder(ValidatorTypeGuesser::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypeExtension($typeExtension)
            ->addTypeGuesser($typeGuesser)
            ->addTypes(array(
                new SiteType(Site::class)
            ))
            ->getFormFactory();

        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }

    public function testEmptyFormType()
    {
        $form = $this->factory->create(SiteType::class);

        $this->assertEmpty($form->getData());
    }
}
