<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Form\DataTransformer;

use Silvestra\Component\Form\KeyValueArray;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 10/8/14 12:16 AM
 */
class KeyValueTransformer implements DataTransformerInterface
{
    /**
     * @var bool
     */
    private $useKeyValueArray;

    /**
     * @param $useKeyValueArray
     */
    public function __construct($useKeyValueArray)
    {
        $this->useKeyValueArray = $useKeyValueArray;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($keyValues)
    {
        return $keyValues;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($keyValues)
    {
        $data = $this->useKeyValueArray ? new KeyValueArray() : array();

        foreach ($keyValues as $keyValue) {
            if ((false === is_array($keyValue)) || (array('key', 'value') != array_keys($keyValue))) {
                throw new TransformationFailedException('Key and value is not valid!');
            }

            if (array_key_exists($keyValue['key'], $data)) {
                throw new TransformationFailedException(sprintf('Duplicate %s key detected!', $keyValue['key']));
            }

            $data[$keyValue['key']] = $keyValue['value'];
        }

        return $data;
    }
}
