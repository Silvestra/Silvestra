<?php

/*
 * This file is part of the Tadcka package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Media\Tests\Image;

use Silvestra\Component\Media\Filesystem;
use Silvestra\Component\Media\Image\ImageCropper;
use Silvestra\Component\Media\Model\Image;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 11/27/14 12:15 AM
 */
class ImageCropperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ImageCropper
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
        $this->filesystem = new Filesystem($this->tempDir);
        $this->cropper = new ImageCropper($this->filesystem);
    }

    public function testCrop()
    {
        $image = $this->createImage();

        $this->cropper->crop($image, array('x1' => '0', 'y1' => 0, 'x2' => 20, 'y2' => 20));
    }

    /**
     * @return Image
     */
    private function createImage()
    {
        $image = new Image();

        $image->setFilename('silvestra.png');
        $image->setOriginalPath(dirname(__FILE__) . '/../Fixtures/silvestra.png');

        return $image;
    }
}
