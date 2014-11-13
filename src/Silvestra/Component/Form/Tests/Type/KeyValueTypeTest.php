<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Form\Tests\Type;

use Silvestra\Component\Form\Type\KeyValueRowType;
use Silvestra\Component\Form\Type\KeyValueType;
use Symfony\Component\Form\Forms;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/8/14 1:20 AM
 */
class KeyValueTypeTest extends AbstractTypeTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypes(array(new KeyValueRowType(), new KeyValueType()))
            ->getFormFactory();
        $this->builder = $this->createFormBuilder();
    }

    public function testEmptyFormType()
    {
        $form = $this->factory->create('silvestra_key_value', null, array('value_type' => 'text'));

        $this->assertEmpty($form->getData());
    }
}
