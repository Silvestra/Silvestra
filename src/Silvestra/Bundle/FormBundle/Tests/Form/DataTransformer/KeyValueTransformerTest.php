<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\FormBundle\Tests\Form\DataTransformer;

use Silvestra\Bundle\FormBundle\Form\DataTransformer\KeyValueTransformer;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class KeyValueTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KeyValueTransformer
     */
    private $transformer;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->transformer = new KeyValueTransformer(false);
    }

    /**
     * Test method: transform().
     */
    public function testTransform()
    {
        $this->assertEmpty($this->transformer->transform(null));
        $this->assertEquals($this->getKeyValues(), $this->transformer->transform($this->getKeyValues()));
    }

    /**
     * Test method: reverseTransform().
     */
    public function testReverseTransform()
    {
        $this->assertEquals(
            array('silvestra_key' => 'Silvestra'),
            $this->transformer->reverseTransform($this->getKeyValues())
        );
    }

    /**
     * Test method: reverseTransform() duplicate detected.
     */
    public function testReverseTransformDuplicateDetected()
    {
        $this->setExpectedException(
            TransformationFailedException::class,
            'Duplicate silvestra_key key detected!'
        );

        $this->transformer->reverseTransform(array_merge($this->getKeyValues(), $this->getKeyValues()));
    }

    /**
     * Test method: reverseTransform() not valid.
     */
    public function testReverseTransformNotValid()
    {
        $this->setExpectedException(
            TransformationFailedException::class,
            'Key and value is not valid!'
        );

        $this->transformer->reverseTransform(array('test', 'test'));
    }

    private function getKeyValues()
    {
        return array(array('key' => 'silvestra_key', 'value' => 'Silvestra'));
    }
}
