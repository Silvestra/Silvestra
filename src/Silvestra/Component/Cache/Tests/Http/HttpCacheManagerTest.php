<?php

/*
 * This file is part of the Silvestra package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silvestra\Component\Cache\Tests\Http;

use Silvestra\Component\Cache\Http\HttpCacheManager;
use Symfony\Component\Filesystem\Filesystem;

class HttpCacheManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var HttpCacheManager
     */
    private $httpCacheManager;

    /**
     * @var string
     */
    private $tmpHttpCacheDir;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->filesystem = new Filesystem();
        $this->tmpHttpCacheDir = sys_get_temp_dir() . '/silvestra_cache/http_cache';

        $this->httpCacheManager = new HttpCacheManager($this->filesystem, $this->tmpHttpCacheDir);
    }

    public function testInvalidateWithoutHttpCacheDir()
    {
        $this->httpCacheManager->invalidateAll();
        $this->assertFalse($this->filesystem->exists($this->tmpHttpCacheDir));
    }

    public function testInvalidate()
    {
        $this->addCacheFile('test', 'test');
        $this->assertTrue($this->filesystem->exists($this->tmpHttpCacheDir . '/test'));
        $this->httpCacheManager->invalidateAll();

        $this->assertFalse($this->filesystem->exists($this->tmpHttpCacheDir));
    }

    private function addCacheFile($filename, $content)
    {
        $this->filesystem->dumpFile($this->tmpHttpCacheDir . '/' . $filename, $content);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->filesystem->remove($this->tmpHttpCacheDir);
    }
}
