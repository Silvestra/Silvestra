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
     * @var string
     */
    private $uploaderFolder;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->filesystem = new Filesystem(__DIR__ . '/');
        $this->uploaderFolder = __DIR__ . DIRECTORY_SEPARATOR . 'silvestra_media';
    }

    public function testGetUploaderFolder()
    {
        $this->assertEquals($this->uploaderFolder, $this->filesystem->getUploaderFolder());
    }

    public function testGetTmpFolder()
    {
        $this->assertEquals($this->uploaderFolder . DIRECTORY_SEPARATOR  . 'tmp', $this->filesystem->getTmpFolder());
    }
}
