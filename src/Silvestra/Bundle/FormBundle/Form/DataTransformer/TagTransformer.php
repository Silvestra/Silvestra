<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Bundle\FormBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 */
class TagTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    private $separator;

    /**
     * Constructor.
     *
     * @param string $separator
     */
    public function __construct($separator)
    {
        $this->separator = $separator;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if ($value) {
            return array('tags' => explode($this->separator, $value));
        }

        return array('tags' => array());
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (isset($value['tags'])) {
            return implode($this->separator, $value['tags']);
        }

        return null;
    }
}
