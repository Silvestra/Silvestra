<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Tests;

use Silvestra\Component\Media\Encryption;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/25/14 11:59 PM
 */
class EncryptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Encryption
     */
    private $encryption;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->encryption = new Encryption('silvestra');
    }

    public function testArray()
    {
        $data = array('silvestra' => 'test', 'test' => 'silvestra');
        $encrypt = $this->encryption->encrypt($data);

        $this->assertEquals($data, $this->encryption->decrypt($encrypt));
    }

    public function testObject()
    {
        $data = new \stdClass();
        $data->silvestra = 'test';
        $data->test = 'silvestra';

        $encrypt = $this->encryption->encrypt($data);

        $this->assertEquals($data, $this->encryption->decrypt($encrypt));
    }
}
