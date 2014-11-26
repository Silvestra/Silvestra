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
use Silvestra\Component\Media\Token\TokenValidator;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/26/14 9:12 PM
 */
class TokenValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TokenValidator
     */
    private $validator;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->validator = new TokenValidator(new TokenGenerator(Media::NAME));
    }

    public function testIsValid()
    {
        $data = array('Silvestra' => 'Media');

        $this->assertFalse($this->validator->isValid('test', $data));
        $this->assertTrue($this->validator->isValid(sha1(Media::NAME . serialize($data)), $data));
    }
}
