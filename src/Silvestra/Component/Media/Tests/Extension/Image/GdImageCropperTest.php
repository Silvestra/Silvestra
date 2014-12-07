<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Tests\Extension\Image;

use Imagine\Gd\Imagine;
use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Extension\Image\GdImageCropper;
use Silvestra\Component\Media\Model\Image;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/27/14 12:15 AM
 */
class GdImageCropperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var SymfonyFilesystem
     */
    private $symfonyFilesystem;

    /**
     * @var GdImageCropper
     */
    private $cropper;

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
        $this->cropper = new GdImageCropper($this->filesystem);
    }

    public function testCrop()
    {
        $coordinates = array('x1' => 0, 'y1' => 0, 'x2' => 20, 'y2' => 40);
        $image = $this->createImage();
        $absolutePath = $this->tempDir . $this->cropper->crop($image, $coordinates);

        $this->assertFileExists($absolutePath);

        $imagine = new Imagine();
        $size = $imagine->open($absolutePath)->getSize();

        $this->assertEquals(40, $size->getHeight());
        $this->assertEquals(20, $size->getWidth());
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->symfonyFilesystem->remove($this->tempDir);
    }

    /**
     * @return Image
     */
    private function createImage()
    {
        $image = new Image();

        $image->setFilename('silvestra.png');
        $image->setOriginalPath($this->filesystem->getRelativeFilePath($image->getFilename()));
        $this->symfonyFilesystem->copy(
            dirname(__FILE__) . '/../../Fixtures/silvestra.png',
            $this->filesystem->getActualFileDir($image->getFilename()) . '/' . $image->getFilename()
        );

        return $image;
    }
}
