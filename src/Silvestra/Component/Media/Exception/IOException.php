<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Exception;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/24/14 11:13 PM
 */
class IOException extends \RuntimeException
{
    /**
     * @var null|string
     */
    private $path;

    /**
     * Constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     * @param null|string $path
     */
    public function __construct($message, $code = 0, \Exception $previous = null, $path = null)
    {
        $this->path = $path;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns the associated path for the exception.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
