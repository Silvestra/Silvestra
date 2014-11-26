<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Token;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/26/14 8:59 PM
 */
class TokenValidator
{
    /**
     * @var TokenGenerator
     */
    private $generator;

    /**
     * Constructor.
     *
     * @param TokenGenerator $generator
     */
    public function __construct(TokenGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Check if token is valid.
     *
     * @param string $token
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($token, $value)
    {
        return $token === $this->generator->generate($value);
    }
}
