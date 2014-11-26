<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Tests\Token;

use Silvestra\Component\Media\Media;
use Silvestra\Component\Media\Token\TokenGenerator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/26/14 9:05 PM
 */
class TokenGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TokenGenerator
     */
    private $generator;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->generator = new TokenGenerator(Media::NAME);
    }

    public function testGenerate()
    {
        $data = array('Silvestra' => 'Media');

        $this->assertEquals($this->getToken($data), $this->generator->generate($data));
    }

    /**
     * Get token.
     *
     * @param mixed $value
     *
     * @return string
     */
    private function getToken($value)
    {
        return sha1(Media::NAME . serialize($value));
    }
}
