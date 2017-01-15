<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\FormBundle\Tests\Form\Type;

use Silvestra\Bundle\FormBundle\Form\Type\TagType;
use Symfony\Component\Form\Forms;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/10/14 10:18 PM
 */
class TagTypeTest extends AbstractTypeTest
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
            ->addTypes(array(
                new TagType()
            ))
            ->getFormFactory();
        $this->builder = $this->createFormBuilder();
    }

    /**
     * Test empty Tag form type.
     */
    public function testEmptyFormType()
    {
        $form = $this->factory->create(TagType::class);

        $this->assertEmpty($form->getData());
    }

    /**
     * Test submit Tag form type.
     */
    public function testFormType()
    {
        $form = $this->factory->create(TagType::class);
        $data = array('tags' => array('Test', 'Silvestra Test'));

        $form->submit($data);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals('Test, Silvestra Test', $form->getData());
    }
}
