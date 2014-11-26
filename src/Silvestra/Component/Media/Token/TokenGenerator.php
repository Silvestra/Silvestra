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
class TokenGenerator
{
    private $key;

    /**
     * Constructor.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Generate token.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function generate($value)
    {
        $hash = $this->key . serialize($value);

        return sha1($hash);
    }
}
