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
use Silvestra\Component\Media\Media;

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
    private $tempDir;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->tempDir = sys_get_temp_dir() . '/sivestra/';
        $this->filesystem = new Filesystem($this->tempDir);
    }

    /**
     * Test method: getMediaRootDir().
     */
    public function testGetMediaRootDir()
    {
        $this->assertEquals($this->getMediaRootDir(), $this->filesystem->getMediaRootDir());
    }

    /**
     * Test method: getActualFileDir().
     */
    public function testGetActualFileDir()
    {
        $this->assertEquals(
            $this->getMediaRootDir() . '/uploader/s/i/l/v/e',
            $this->filesystem->getActualFileDir('silvestra.png')
        );

        $this->assertEquals(
            $this->getMediaRootDir() . '/uploader/t/e/s/t',
            $this->filesystem->getActualFileDir('test.png')
        );
    }

    /**
     * Test method: getActualFileDir() with empty filename.
     */
    public function testGetActualFileDirWithEmptyFilename()
    {
        $this->setExpectedException('Silvestra\\Component\\Media\\Exception\\InvalidArgumentException');

        $this->filesystem->getActualFileDir('');
    }

    /**
     * Test method: mkdir() with empty filename.
     */
    public function testMkdir()
    {
        $dir = $this->filesystem->getActualFileDir('silvestra.png');
        $this->filesystem->mkdir($dir);

        $this->assertFileExists($dir);
    }

    public function testGetRelativeFilePath()
    {
        $this->assertEquals(
            '/silvestra_media/uploader/s/i/l/v/e/silvestra.png',
            $this->filesystem->getRelativeFilePath('silvestra.png')
        );
    }

    public function testGetAbsoluteFilePath()
    {
        $this->assertEquals(
            $this->getMediaRootDir() . '/uploader/s/i/l/v/e/silvestra.png',
            $this->filesystem->getAbsoluteFilePath('silvestra.png')
        );
    }

    private function getMediaRootDir()
    {
        return $this->tempDir . Media::NAME;
    }
}
