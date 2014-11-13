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
use Symfony\Component\Form\Forms;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/8/14 1:19 AM
 */
class KeyValueRowTypeTest extends AbstractTypeTest
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypes(array(new KeyValueRowType()))
            ->getFormFactory();
        $this->builder = $this->createFormBuilder();
    }

    /**
     * Test empty KeyValueRow form type.
     */
    public function testEmptyFormType()
    {
        $form = $this->createForm(null);

        $this->assertEmpty($form->getData());
    }

    /**
     * Test submit KeyValueRow form type.
     */
    public function testFormType()
    {
        $form = $this->createForm(null);
        $data = array('key' => 'silvestra_key', 'value' => 'Silvestra');
        $form->submit($data);
        $formData = $form->getData();

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals('silvestra_key', $formData['key']);
        $this->assertEquals('Silvestra', $formData['value']);
    }

    /**
     * Test submit KeyValueRow form type with allowed keys.
     */
    public function testFormTypeWithAllowedKeys()
    {
        $form = $this->createForm(null, array('value_type' => 'text', 'allowed_keys' => array('Bar', 'Foo')));
        $data = array('key' => 1, 'value' => 'Silvestra');
        $form->submit($data);
        $formData = $form->getData();

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(1, $formData['key']);
        $this->assertEquals('Silvestra', $formData['value']);
    }

    private function createForm($data, $options = array('value_type' => 'text'))
    {
        return $this->factory->create('silvestra_key_value_row', $data, $options);
    }
}
