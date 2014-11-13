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

    /**
     * Test empty KeyValue form type.
     */
    public function testEmptyFormType()
    {
        $form = $this->createForm(null);

        $this->assertEmpty($form->getData());
    }

    /**
     * Test submit KeyValue form type.
     */
    public function testFormType()
    {
        $form = $this->createForm(null);
        $form->submit($this->getData());
        $formData = $form->getData();

        $this->assertTrue($form->isSynchronized());
        $this->assertCount(2, $formData);
        $this->assertEquals('Silvestra', $formData['silvestra_key']);
        $this->assertEquals('Bar', $formData['bar_key']);
    }

    private function createForm($data, $options = array('value_type' => 'text'))
    {
        return $this->factory->create('silvestra_key_value', $data, $options);
    }

    private function getData()
    {
        return array(
            array('key' => 'silvestra_key', 'value' => 'Silvestra'),
            array('key' => 'bar_key', 'value' => 'Bar')
        );
    }
}
