<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/25/14 11:53 PM
 */
class Encryption
{
    const ENCRYPT_METHOD = 'AES-256-CBC';

    /**
     * @var string
     */
    private $key;

    /**
     * Constructor.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = hash('sha256', $key);
    }

    /**
     * Encrypt.
     *
     * @param mixed $encrypt
     *
     * @return string
     */
    public function encrypt($encrypt)
    {
        return base64_encode(openssl_encrypt(serialize($encrypt), self::ENCRYPT_METHOD, $this->key, 0, $this->getIv()));
    }

    /**
     * Decrypt.
     *
     * @param string $decrypt
     *
     * @return bool|mixed
     */
    public function decrypt($decrypt)
    {
        return unserialize(
            openssl_decrypt(base64_decode($decrypt), self::ENCRYPT_METHOD, $this->key, 0, $this->getIv())
        );
    }

    /**
     * Get initialization vector.
     *
     * @return string
     */
    private function getIv()
    {
        return substr(hash('sha256', Media::NAME), 0, 16);
    }
}
