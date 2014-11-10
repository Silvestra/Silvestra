<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Form\Tests\DataTransformer;

use Silvestra\Component\Form\DataTransformer\TagTransformer;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/10/14 10:11 PM
 */
class TagTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TagTransformer
     */
    private $transformer;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->transformer = new TagTransformer(', ');
    }

    /**
     * Test method: transform().
     */
    public function testTransform()
    {
        $this->assertEquals(array('tags' => array()), $this->transformer->transform(null));
        $this->assertEquals(
            array('tags' => array('test', 'test mock')),
            $this->transformer->transform('test, test mock')
        );
    }

    /**
     * Test method: reverseTransform().
     */
    public function testReverseTransform()
    {
        $this->assertEmpty($this->transformer->reverseTransform(null));
        $this->assertEquals(
            'test, test mock',
            $this->transformer->reverseTransform(array('tags' => array('test', 'test mock')))
        );
    }
}
