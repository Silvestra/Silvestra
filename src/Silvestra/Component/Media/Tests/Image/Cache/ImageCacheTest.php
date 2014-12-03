<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Tests\Image\Cache;

use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Image\Cache\ImageCache;
use Silvestra\Component\Media\Media;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 12/2/14 11:54 PM
 */
class ImageCacheTest extends \PHPUnit_Framework_TestCase
{
    const FILENAME = 'silvestra.png';
    const KEY = '/qwer/tawer/';

    /**
     * @var ImageCache
     */
    private $imageCache;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var SymfonyFilesystem
     */
    private $symfonyFilesystem;

    /**
     * @var string
     */
    private $tempDir;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->tempDir = sys_get_temp_dir() . '/sivestra';
        $this->symfonyFilesystem = new SymfonyFilesystem();

        $this->symfonyFilesystem->remove($this->tempDir);

        $this->filesystem = new Filesystem($this->tempDir);
        $this->imageCache = new ImageCache($this->filesystem);
    }

    public function testGetAbsolutePath()
    {
        $this->assertEquals(
            $this->tempDir . '/' . Media::NAME . '/cache/qwer/tawer/silvestra.png',
            $this->imageCache->getAbsolutePath(self::FILENAME, self::KEY)
        );
    }

    public function testContains()
    {
        $this->assertFalse($this->imageCache->contains(self::FILENAME, self::KEY));

        $this->createCacheImage();

        $this->assertTrue($this->imageCache->contains(self::FILENAME, self::KEY));
    }

    public function testRemove()
    {
        $this->createCacheImage();
        $this->imageCache->remove(self::FILENAME, self::KEY);

        $this->assertFalse($this->imageCache->contains(self::FILENAME, self::KEY));
    }

    private function createCacheImage()
    {
        $this->symfonyFilesystem->copy(
            dirname(__FILE__) . '/../../Fixtures/silvestra.png',
            $this->imageCache->getAbsolutePath(self::FILENAME, self::KEY)
        );
    }
}
