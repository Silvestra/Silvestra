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

use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
abstract class AbstractTypeTest extends TypeTestCase
{
    /**
     * @return FormBuilder
     */
    protected function createFormBuilder()
    {
        return new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }

    /**
     * @return FormTypeValidatorExtension
     */
    protected function createValidatorExtension()
    {
        $validator = $this->getMock('Symfony\\Component\\Validator\\Validator\\ValidatorInterface');
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));

        return new FormTypeValidatorExtension($validator);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ValidatorTypeGuesser
     */
    protected function getMockValidatorTypeGuesser()
    {
        return $this->getMockBuilder('Symfony\\Component\\Form\\Extension\\Validator\\ValidatorTypeGuesser')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
