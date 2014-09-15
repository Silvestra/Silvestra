<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Tests;

use Silvestra\Component\Media\Filesystem;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 14.9.14 00.10
 */
class FilesystemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->filesystem = new Filesystem(__DIR__ . '/');
    }

    public function testGetUploaderFolder()
    {
        $this->assertEquals(__DIR__, $this->filesystem->getUploaderFolder());
    }

    public function testGetTmpFolder()
    {
        $this->assertEquals(__DIR__ . DIRECTORY_SEPARATOR  . 'tadcka_media_tmp', $this->filesystem->getTmpFolder());
    }
}
