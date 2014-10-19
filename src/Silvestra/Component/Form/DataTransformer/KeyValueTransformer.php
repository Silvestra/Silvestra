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
    public function transform($keyValue)
    {
        return $keyValue;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($keyValue)
    {
        $data = $this->useKeyValueArray ? new KeyValueArray() : array();

        foreach ($keyValue as $keyValueRow) {
            if (array('key', 'value') != array_keys($keyValueRow)) {
                throw new TransformationFailedException('Key value row is not valid!');
            }

            if (array_key_exists($keyValueRow['key'], $data)) {
                throw new TransformationFailedException(sprintf('Duplicate %s key detected!', $data['key']));
            }

            $data[$keyValueRow['key']] = $keyValueRow['value'];
        }

        return $data;
    }
}
